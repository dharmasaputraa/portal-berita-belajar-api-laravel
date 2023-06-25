<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'author_id' => $this->author_id,
            'author' => $this->whenLoaded('author'),
            'commet_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return collect($this->comments)->map(function ($comment) {
                    return [
                        'id' => $comment->commentator->id,
                        'username' => $comment->commentator->username,
                        'comments_content' => $comment->comments_content
                    ];
                });
            }),
        ];
    }
}
