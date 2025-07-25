<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'image_url' => $this->image_url,
            'is_active' => $this->is_active,
            'order_index' => $this->order_index,
            'program_studi' => new ProgramStudiResource($this->whenLoaded('programStudi')),
        ];
    }
}
