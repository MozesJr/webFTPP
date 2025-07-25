<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MataKuliahResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'credits' => $this->credits,
            'semester' => $this->semester,
            'category' => $this->category,
            'prerequisite' => $this->prerequisite,
            'description' => $this->description,
            'learning_outcomes' => $this->learning_outcomes,
            'is_active' => $this->is_active,
            'kurikulum' => new KurikulumResource($this->whenLoaded('kurikulum')),
        ];
    }
}
