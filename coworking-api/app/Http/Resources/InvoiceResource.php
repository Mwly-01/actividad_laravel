<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'payment_id' => $this->payment_id,
            'number'     => $this->number,
            'issued_date'     => $this->issued_date,
            'meta'      => $this->meta,
        ];
    }
}
