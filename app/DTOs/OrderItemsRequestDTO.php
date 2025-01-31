<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class OrderItemsRequestDTO extends Data
{
    public string $product_name;
    public int $quantity;
    public float $price;

  
}
