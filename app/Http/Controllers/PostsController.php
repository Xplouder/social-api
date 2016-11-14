<?php

namespace App\Http\Controllers;

use App\Post;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Create Post
     *
     * Create a post from the authenticated user.
     * Returns the public user information.
     *
     * `POST https://example.com/api/v1/posts`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * body_text | string | optional | post text message
     * body_image | image | optional | post image file
     * public | string | required | post visibility: `yes` or `no`
     *
     * Note: at least one body part need to be submitted
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validatePost($data);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $post = new Post();
        $post->public = $data['public'];
        $post->body_text = $data['body_text'];
        if ($request->hasFile('body_image') && $request->file('body_image')->isValid()) {
            $url = Storage::putFile('images', $data['body_image'], 'public');
            $post->body_image = pathinfo($url, PATHINFO_BASENAME);
        }
        $post->user_id = Auth::user()->id;
        $post->save();

        return response()->json($post, 201);
    }

    /**
     * Get Image
     *
     * Get image resource
     *
     * `GET https://example.com/api/v1/images/{filename}`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * filename | string | required | image filename
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param $filename
     * @return JsonResponse
     * @internal param Request $request
     */
    public function getBodyImage($filename)
    {
        if (!$filename) {
            return response()->json(['message' => 'The given filename image do not exist'], 404);
        }

        if (!Storage::has('images/' . $filename)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $file = Storage::get('images/' . $filename);
        return response($file)->header('Content-Type', 'image/' . pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Update/Edit Post
     *
     * Edit the data of a post. Return the post with the updated data.
     *
     * `PUT https://example.com/api/v1/posts/{post}`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * post | int | required | the post identifier
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Check permissions
        if (Auth::user()->id != $post->user_id) {
            return response()->json(['message' => 'You haven\'t permission to change this entry',], 401);
        }

        $data = $request->all();
        $validator = $this->validatePost($data);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $post->fill($request->all());
        $post->save();

        return response()->json($post);
    }

    /**
     * Remove Post
     *
     * Remove a post.
     *
     * `DELETE https://example.com/api/v1/posts/{post}`
     *
     * Parameter | Type    | Status  | Description
     * --------- | ------- | ------- | -----------
     * post | int | required | the post identifier
     *
     * <aside class="warning">
     * <b>Required</b>: You must add <b>Authorization: Bearer YOUR_TOKEN</b> to your headers.
     * </aside>
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Check permissions
        if (Auth::user()->id != $post->user_id) {
            return response()->json(['message' => 'You haven\'t permission to delete this entry'], 401);
        }

        return response()->json($post->delete(), 204);
    }

    private function validatePost($requestData)
    {
        return Validator::make($requestData, [
            'body_text' => 'required_if:body_image,null|max:500',
            'body_image' => 'required_if:body_text,""|image|max:2048',
            'public' => 'required|in:yes,no',
        ]);
    }
}
