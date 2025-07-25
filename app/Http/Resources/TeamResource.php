<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'photo_url' => $this->photo_url,
            'education' => $this->education,
            'expertise' => $this->expertise,
            'is_active' => $this->is_active,
            'order_index' => $this->order_index,
            'position' => new TeamPositionResource($this->whenLoaded('position')),
            'program_studi' => new ProgramStudiResource($this->whenLoaded('programStudi')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
