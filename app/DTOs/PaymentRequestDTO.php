<?php

namespace App\DTOs;

use App\Enums\PaymentGatewaysEnum;
use Spatie\LaravelData\Data;

class PaymentRequestDTO extends Data
{
  public PaymentGatewaysEnum $payment_method;
}
