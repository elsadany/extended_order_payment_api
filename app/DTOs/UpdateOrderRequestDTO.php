<?php

namespace App\DTOs;

use App\Enums\OrdersStatusEnum;
use Spatie\LaravelData\Data;

class UpdateOrderRequestDTO extends Data
{
    public OrdersStatusEnum     $status;
}
