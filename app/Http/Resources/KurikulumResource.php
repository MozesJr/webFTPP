<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KurikulumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'academic_year' => $this->academic_year,
            'total_credits' => $this->total_credits,
            'document_url' => $this->document_url,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'mata_kuliahs' => MataKuliahResource::collection($this->whenLoaded('mataKuliahs')),
            'program_studi' => new ProgramStudiResource($this->whenLoaded('programStudi')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
