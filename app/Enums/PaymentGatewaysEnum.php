<?php

namespace App\Enums;

enum PaymentGatewaysEnum :string
{
    case PAYPAL = 'paypal';
    case CREDITCARD = 'credit_card';
    case ALIPAY = 'alipay';
}
