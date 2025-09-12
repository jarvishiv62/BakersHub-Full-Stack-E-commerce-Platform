<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_sku' => $this->product_sku,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'product_options' => $this->product_options,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}