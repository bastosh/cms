<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
		return PostResource::collection(Post::latest()->paginate(5));

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
		$this->validate($request, [
		  'title' => 'required',
		  'body' => 'required',
		  'user_id' => 'required',
		  'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
		]);

		$post = new Post;

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$name = str_slug($request->title).'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/posts');
			$imagePath = $destinationPath . "/" . $name;
			$image->move($destinationPath, $name);
			$post->image = $name;
		}

		$post->user_id = $request->user_id;
		$post->title = $request->title;
		$post->body = $request->body;
		$post->save();

		return new PostResource($post);
    }

    public function show(Post $post)
    {
		return new PostResource($post);
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
		$this->validate($request, [
		  'title' => 'required',
		  'body' => 'required',
		]);

		$post->update($request->only(['title', 'body']));

		return new PostResource($post);
    }

    public function destroy(Post $post)
    {
		$post->delete();

		return response()->json(null, 204);
    }
}
