<?php

namespace App\Services\Payments\Gateways;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\Payments\PaymentGatewayInterface;

class AliPayGateway implements PaymentGatewayInterface
{
    protected $api_key;
    protected $secret_key;

    function __construct()
    {
        $this->api_key = env('ALI_PAY_API_KEY');
        $this->secret_key = env('ALI_PAY_SECRET_KEY');
    }

    public function processPayment(Payment $payment)
    {
        // Simulate AliPay payment processing logic
        $payment->status = PaymentStatusEnum::SUCCESSFUL->value;; // Mock response
        $payment->payment_id = 'AP-' . uniqid();
        $payment->save();

        return $payment;
    }
}
