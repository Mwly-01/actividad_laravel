<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'name' => $this->name,
            'capacity' => $this->capacity,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'spaces' => $this->whenLoaded('spaces', function () {
                return [
                    'id' => $this->spaces->id,
                    'name' => $this->spaces->name
                ];
            }),
        ];
    }
}
