<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PostController extends Controller
{
    public function index()
    {
        $post = post::latest()->get();
        return PostResource::collection($post);
    }

    public function store(Request $request)
    {
        $rules = [
            "message" => "required|string|between:2,1000",
        ];

        $customMessages = [
            'message.required' => 'Le champ message est obligatoire.',
            'message.between' => 'Le texte ne doit pas faire plus de 1000 caractères.',
        ];

        $validator = Validator::make($request->all(), [
            "message" => "required",
        ]);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 401);
        }

        $post = New Post;
        $post->message = $request->message;
        $post->user()->associate($request->user());
        
        $post->save();

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $rules = [
            "message" => "required|string|between:2,1000",
        ];

        $customMessages = [
            'message.required' => 'Le champ message est obligatoire.',
            'message.between' => 'Le texte ne doit pas faire plus de 1000 caractères.',
        ];

        $validator = Validator::make($request->all(), [
            "message" => "required",
        ]);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 401);
        }
        
        $post->message = $request->get('message', $post->message);
        
        $post->save();

        return new PostResource($post);;
    }

    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        return response(null, 204);
    }
}
