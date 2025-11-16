<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all posts
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required'
        ]);

        // Create post
        $post = Post::create($fields);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Return single post
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find post
        $post = Post::findOrFail($id);

        // Validate input
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required'
        ]);

        // Update post
        $post->update($fields);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find post
        $post = Post::findOrFail($id);

        // Delete post
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
