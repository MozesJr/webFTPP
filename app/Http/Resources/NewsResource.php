<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->when($request->routeIs('*.show'), $this->content),
            'featured_image' => $this->featured_image,
            'status' => $this->status,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'views_count' => $this->views_count,
            'is_featured' => $this->is_featured,
            'tags' => $this->tags,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'category' => new NewsCategoryResource($this->whenLoaded('category')),
            'author' => new TeamResource($this->whenLoaded('author')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
