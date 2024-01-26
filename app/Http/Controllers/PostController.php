<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    // display all post in index page
    public function index(): View
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //render view with posts
        return view('posts.index', compact('posts'));
    }

    // display post create form
    public function create(): View
    {
        //render view
        return view('posts.create');
    }

    // display store post
    public function store(Request $request): RedirectResponse
    {
        //validate request form
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048', //validate image
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:3|max:255',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //store request
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        //redirect and send message
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /// find specific data by id
    public function show(String $id): View
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // edit post
    public function edit(String $id): View
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        /// add form validation
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:3|max:255',
        ]);

        /// Get post by id
        $post = Post::findOrFail($id);

        /// check if image has already been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            /// delete old image
            Storage::disk('local')->delete('public/posts/' . $post->image);

            /// update post with image
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            /// update post without image
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        /// redirect with message
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        /// Get post by id
        $post = Post::findOrFail($id);

        /// delete image
        Storage::disk('local')->delete('public/posts/' . $post->image);

        /// delete post
        $post->delete();

        /// redirect with message
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
