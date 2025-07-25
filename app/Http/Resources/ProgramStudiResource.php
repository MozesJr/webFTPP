<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramStudiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'degree_level' => $this->degree_level,
            'description' => $this->description,
            'overview' => $this->overview,
            'image_url' => $this->image_url,
            'accreditation' => $this->accreditation,
            'accreditation_date' => $this->accreditation_date?->format('Y-m-d'),
            'accreditation_expire' => $this->accreditation_expire?->format('Y-m-d'),
            'head_of_program' => $this->head_of_program,
            'established_year' => $this->established_year,
            'is_active' => $this->is_active,
            'features_count' => $this->whenCounted('features'),
            'teams_count' => $this->whenCounted('teams'),
            'kurikulums_count' => $this->whenCounted('kurikulums'),
            'features' => FeatureResource::collection($this->whenLoaded('features')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'kurikulums' => KurikulumResource::collection($this->whenLoaded('kurikulums')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
