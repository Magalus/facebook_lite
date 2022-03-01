<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    
    {
        $rules = [
            "message" => "required|string|between:2,1000",
        ];

        $customMessages = [
            'message.required' => 'Le champ message est obligatoire.',
            'message.between' => 'Le texte ne doit pas faire plus de 1000 caractères.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 401);
        }

        $comment = New Comment;
        $comment->message = $request->message;
        $comment->user()->associate($request->user());

        $post->comments()->save($comment);

        return new CommentResource($comment);
    }

    public function show(Request $request, Post $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(Request $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $rules = [
            "message" => "required|string|between:2,1000",
        ];

        $customMessages = [
            'message.required' => 'Le champ message est obligatoire.',
            'message.between' => 'Le texte ne doit pas faire plus de 1000 caractères.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 401);
        }

        $comment->body = $request->get('message', $comment->message);
        $comment->save();

        return new CommentResource($comment);
    }

    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('destroy', $comment);
        $comment->delete();
		return response(null, 204);
    }
}
