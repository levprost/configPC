<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all()->with(['user', 'post']);
        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
