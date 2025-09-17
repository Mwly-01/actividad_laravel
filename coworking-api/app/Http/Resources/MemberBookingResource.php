<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberBookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'member_id'  => $this->member_id,
            'booking_id' => $this->id,
            'room'       => new RoomResource($this->whenLoaded('room')),
            'status'     => $this->status,
            'purpose'    => $this->purpose,
        ];
    }
}