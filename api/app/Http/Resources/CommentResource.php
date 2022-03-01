<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
	public function toArray($request) {
		return [
			'id' => $this->id,
			'message' => $this->message,
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
			'like_count' => $this->likes->count(),
			'likes_user_id' => $this->likes->pluck('user.id'),
			'likes_user_name' => $this->likes->pluck('user.name'),
			'user' => $this->user,
		];
	}
}
