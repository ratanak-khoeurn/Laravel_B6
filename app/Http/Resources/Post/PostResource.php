<?php

namespace App\Http\Resources\post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->id,
            'image_url' => $this->image_url,
            'description' => $this->description,
            'user'=>$this->getUser,
            'comments'=>$this->getAllComments,
            'like_count'=>$this->getAllLikes->count(),

       ];
    }
}
