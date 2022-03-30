<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Jobs\PruneOldPostsJob;
use NumberFormatter;
use App\Rules\postNumbers;


class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);
        $end_old_posts = Post::all();
        dispatch(new PruneOldPostsJob($end_old_posts));
        return view("posts.index", compact('posts'));
    }

    public function create()
    {
        $users = User::all();
        return view("posts.create" , compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts|min:3',
            'desc' => 'required|min:10',
            'post_numbers' => ['required', new postNumbers()]
        ]);

        $user = User::findOrFail($request->user_id);
        $numofposts=$user->post_numbers + 1;
        $user->post_numbers = $numofposts;
        $user->save () ; 

        $request_data = request()->all();
        $post = new Post();
        $post->title = $request_data["title"];
        $post->desc = $request_data["desc"];
        $post->slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        $post->user_id =request("user_id");
        $post->save();

        return to_route("posts.index")->with('success', 'Student has been added');
    }

    public function show($id)
    {
        $data = Post::find($id);
        return view("posts.view",compact('data')); 
    }

    public function edit($id)
    {
        $data = Post::find($id);
        $users = User::all();
        return view("posts.edit",compact('data','users'));
        
    }

    public function update(Request $request , Post $post)
    {

        $this->authorize("Belongs",$post);
        
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,'.$post->id,
            'desc' => 'required|min:10',
        ]);
       
        // $post = Post::find($id);
        $post->title =request("title");
        $post->desc =request("desc");
        $post->slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        $post->user_id= request("user_id");
        $post->save();

        return to_route("posts.index");
    
    }

  

    public function destroy(Post $post)
    {

        $user = User::findOrFail($post->user_id);
        $user->post_numbers= $user->post_numbers-1 ; 
        $user->save () ; 

        $this->authorize("Belongs",$post);
        // Post::find($id)->delete();
        $post->delete();
        return to_route("posts.index");
    }

    
}
