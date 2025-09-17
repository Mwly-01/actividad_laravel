<?php

namespace App\Http\Resources;

use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'member_id' => $this->member_id,
            'room'      => new RoomResource($this->whenLoaded('room')),
            'start_at'     => $this->start_at,
            'end_at'     => $this->end_at,
            'status'      => $this->status,
            'purpose'     => $this->purpose
        ];
    }
}
