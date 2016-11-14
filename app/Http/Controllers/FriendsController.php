<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class FriendsController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Add Friend
     *
     * Set friendship between the authenticated user and the given friend identifier.
     *
     * `POST https://example.com/api/v1/friends`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * friend | int | required | the friend identifier
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addFriend(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'friend' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $friend = User::find($request['friend']);
        if (!$friend) {
            return response()->json(['message' => 'User with id ' . $request['friend'] . ' not found'], 404);
        }

        $authenticatedUser = Auth::user();

        if ($request['friend'] == $authenticatedUser->id) {
            return response()->json(['message' => 'You can not be friend of yourself :)'], 400);
        }

        try {
            User::find($authenticatedUser->id)->friends()->attach($friend->id);
            User::find($friend->id)->friends()->attach($authenticatedUser->id);
        } catch (QueryException $e) {
            return response()->json(['message' => 'User ' . $authenticatedUser->id . ' is already friend of user ' . $friend->id], 409);
        }

        return response()->json([
            'message' =>
                'User id-' . $authenticatedUser->id . ' and id-' . $friend->id . ' are now friends.'], 201);
    }

    /**
     * Friends List
     *
     * Return the friends of the authenticated user.
     *
     * `GET https://example.com/api/v1/friends`
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @return JsonResponse
     */
    public function index(){
        $authenticatedUser = Auth::user();
        return response()->json(User::find($authenticatedUser->id)->friends()->paginate(Input::get('perPage', 15)), 201);
    }
}
