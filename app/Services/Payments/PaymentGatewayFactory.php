<?php

namespace App\Services\Payments;

use App\Services\Payments\Gateways\AliPayGateway;
use App\Services\Payments\Gateways\CreditCardGateway;
use App\Services\Payments\Gateways\PayPalGateway;

class PaymentGatewayFactory
{
    public static function create(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'credit_card' => new CreditCardGateway(),
            'paypal' => new PayPalGateway(),
            'alipay' => new AliPayGateway(),
            default => throw new \Exception('Unsupported Payment Gateway'),
        };
    }
}