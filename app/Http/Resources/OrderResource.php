<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['items']);
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'total_amount' => $this->total_amount,
            'items' => OrderItemResource::collection($this->items)
        ];
    }
}
