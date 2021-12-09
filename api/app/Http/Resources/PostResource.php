<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
	public function toArray($request) {
		return [
			'id' => $this->id,
			'message' => $this->message,
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
			'user' => $this->user,
		];
	}
}
