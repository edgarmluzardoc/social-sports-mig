<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Gets all posts for home page
     */
    public function getIndex()
    {
        // TODO add pagination
        $posts = Post::orderBy('created_at', 'desc')->get();
        $params = [
            'posts' => $posts
        ];
        return view('post.index', $params);
    }

    /**
     * New - Create view page
     */
    public function getPostCreate()
    {
        return view('post.create');
    }

    /**
     * New - Create post action
     */
    public function postPostCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $post->save();
        return redirect()->route('post.index')->with('info', 'Post created!');
    }

    /**
     * Edit - View post to edit
     */
    public function getPostEdit($id)
    {
        $post = Post::find($id);
        $params = [
            'post' => $post,
            'postId' => $id
        ];
        return view('post.edit', $params);
    }

    /**
     * Edit - Update post action
     */
    public function postPostUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        return redirect()->route('post.index')->with('info', 'Post edited!');
    }

    /**
     * Delete - Update post action
     */
    public function getPostDelete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.index')->with('info', 'Post deleted!');
    }
}
