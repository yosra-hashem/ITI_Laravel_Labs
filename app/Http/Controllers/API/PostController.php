<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Validator;
   
class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
    
        return $this->sendResponse(PostResource::collection($posts), 'Post retrieved successfully.');
    }

    
    public function store(Request $request)
    {
   
        $validator = Validator( [
            'title' => 'required',
            'desc' => 'required'
        ]);
   
       
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $user = auth('sanctum')->user();
        $request["user_id"] = $user->id;
        $post = Post::create($request->all());
        return new PostResource($post);

   
        return $this->sendResponse(new PostResource($post), 'Post created successfully.');
    } 
   
   
    public function show($id)
    {
        $post = Post::find($id);
  
        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }
   
        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }
    
   
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $post->title = $input['title'];
        $post->desc = $input['desc'];
        $post->save();
   
        return $this->sendResponse(new PostResource($post), 'Post updated successfully.');

       
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
   
        return $this->sendResponse([], 'Post deleted successfully.');
    }
}