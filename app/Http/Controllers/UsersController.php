<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use Validator;

class UsersController extends Controller
{
    /**
     * User Feed
     *
     * Get posts and profile data of the specified user. The given posts are based on the authentication state and the
     * friendship relation:
     * * If the user is anonymous, he will only get public posts.
     * * If he is authenticated and is friend of the specified user beside the public posts he will also get the private ones.
     *
     * `PUT https://example.com/api/v1/users/{id}`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * id | int | required | the user identifier
     *
     * <aside class="notice">
     * <b>Optional</b>: You can add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'perPage' => 'int',
            'page' => 'int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $perPage = (int)Input::get('perPage', 15);

        // -------------------------------------------------------------------------------------------------------------

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $authenticatedUser = null;
        if (JWTAuth::getToken()) {
            $authenticatedUser = JWTAuth::parseToken()->authenticate();
        }

        // Check if the user is authenticated
        if ($authenticatedUser) {
            // Authenticated
            if ($authenticatedUser->id == $user->id) {  // consulting his own posts
                // checking own profile
                // fetch the last updated posts from user with pagination parameters (perPage and page)
                $postsWithPagination = $user
                    ->posts()
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
            } else if (User::find($authenticatedUser->id)->friends()->find($user->id)) { // consulting a friend posts
                // friends
                // all the posts (public + private)
                $postsWithPagination = $user
                    ->posts()
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
            } else { // not friends
                // not friends
                // only public posts
                $postsWithPagination = $user
                    ->posts()
                    ->orderBy('created_at', 'desc')
                    ->where('public', '=', 'yes')
                    ->paginate($perPage);
            }
        } else {
            // not authenticated
            // only public posts
            $postsWithPagination = $user
                ->posts()
                ->orderBy('created_at', 'desc')
                ->where('public', '=', 'yes')
                ->paginate($perPage);
        }

        // remove 'posts' relation
        $response = User::find($user->id)->toArray();
        unset($response['posts']);

        $response = array_merge($response, ['posts' => $postsWithPagination->toArray()]);
        return response()->json($response);
    }

    /**
     * Create Account
     *
     * Create a new account for the given data
     *
     * `POST https://example.com/api/v1/users`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * name | string | required | max length: 100
     * email | string | required | Has to be email format
     * password | string | required | |
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:100',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // if exists already a user with same email as the one from request input, just update the old contact with
        // the password and update social parameter to "no"
        if ($user = User::where('email', $data['email'])->where('social', 'yes')->first()) {
            $password = $request->only('password')["password"];
            $user->password = Hash::make($password);
            $user->social = 'no';
            $user->save();
            return response()->json($user, 201);
        }

        // -----------

        $validator = Validator::make($data, [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }


        $user = new User();

        $user->fill($data);
        $password = $request->only('password')["password"];
        $user->password = Hash::make($password);
        $user->save();
        return response()->json($user, 201);
    }

    /**
     * Global Feed
     *
     * Return the posts based on authentication state and friends.
     * If the user is anonymous he will get the most recent public posts, if he is authenticated he will
     * get most recent public, friends and own posts.
     *
     * `GET https://example.com/api/v1/feed`
     *
     * <aside class="notice">
     * <b>Optional</b>: You can add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function feed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'perPage' => 'int',
            'page' => 'int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $page = (int)Input::get('page', 1);
        $perPage = (int)Input::get('perPage', 15);

        // -------------------------------------------------------------------------------------------------------------

        $authenticatedUser = null;
        if (JWTAuth::getToken()) {
            $authenticatedUser = JWTAuth::parseToken()->authenticate();
        }

        $posts = null;
        if (!$authenticatedUser) {
            // Retrieve all the public posts from everyone
            $posts = Post::where('public', 'yes')->orderBy('created_at', 'desc')->get()->toArray();
        } else {

            // Retrieve all the public posts from everyone and private posts of authenticated user and his friends
            $publicPosts = Post::where('public', 'yes');

            // ----------

            $authenticatedUserPosts = Post::where('user_id', $authenticatedUser->id);

            // ----------

            $privateFriends = User::find($authenticatedUser->id)->friends()->select('id')->get();
            $privateFriendsArray = [];
            foreach ($privateFriends as $friend) {
                array_push($privateFriendsArray, $friend->id);
            }

            $friendsPrivatePosts = Post::where('public', 'no')
                ->whereIn('user_id', $privateFriendsArray);

            // ----------

            $posts = $publicPosts->union($authenticatedUserPosts);

            $posts = array_merge($posts->get()->toArray(), $friendsPrivatePosts->get()->toArray());

            usort($posts, array($this, "sortFunction"));
        }

        // ---------------------------------------------------------------------------------------------------------

        // Custom Paginator due the error/bug/not implemented paginated method after "unions"
        $slice = array_slice($posts, $perPage * ($page - 1), $perPage);

        $response = new LengthAwarePaginator(
            $slice,
            count($slice),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]);

        return response()->json($response, 200);

    }

    private function sortFunction($a, $b)
    {
        return strtotime($b["created_at"]) - strtotime($a["created_at"]);
    }
}
