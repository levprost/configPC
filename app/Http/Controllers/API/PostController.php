<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all()->load('media');
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title_post' => 'required|string',
            'content_post' => 'required',
            'content_post_1' => 'required',
            'content_post_2' => 'required',
            'subtitle_post' => 'required|string',
            'description_post' => 'required|string',
            'is_published' => 'required|boolean',
            'order_post' => 'sometimes|integer',
            'user_id' => 'required|integer',
        ]);
        Post::create($formFields);
        return response()->json([
            'status' => 'Création effectuée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $formFields = $request->validate([
            'title_post' => 'required|string',
            'content_post' => 'required',
            'content_post_1' => 'required',
            'content_post_2' => 'required',
            'subtitle_post' => 'required|string',
            'description_post' => 'required|string',
            'is_published' => 'required|boolean',
            'order_post' => 'sometimes|integer',
            'user_id' => 'required|integer',
        ]);
        $post->update($formFields);
        return response()->json([
            'status' => 'Mise à jour effectuée avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
