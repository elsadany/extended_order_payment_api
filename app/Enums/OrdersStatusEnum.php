<?php

namespace App\Enums;

enum OrdersStatusEnum :string
{
    case PENDING  = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
}
