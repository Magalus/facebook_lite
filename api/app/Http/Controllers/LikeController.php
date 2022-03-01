<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeProject(Request $request, Post $post) {

        if ($post->likes->where('user_id', $request->user()->id)->count() > 0) {
            $post->likes()->where('user_id', $request->user()->id)->delete();
            return response()->json([
                "message" => "Projet déliké avec succès"
            ]);
        }

		$like = new Like;
		$like->user()->associate($request->user());
		$post->likes()->save($like);

        return response()->json([
            "message" => "Projet liké avec succès"
        ]);
	}

    public function likeComment(Request $request, Post $post, Comment $comment) {

        if ($comment->likes->where('user_id', $request->user()->id)->count() > 0) {
            $comment->likes()->where('user_id', $request->user()->id)->delete();
            return response()->json([
                "message" => "Commentaire déliké avec succès"
            ]);
        }

		$like = new Like;
		$like->user()->associate($request->user());
		$comment->likes()->save($like);

        return response()->json([
            "message" => "Commentaire liké avec succès"
        ]);
	}
}

