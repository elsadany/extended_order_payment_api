<?php

namespace App\Services\Payments\Gateways;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\Payments\PaymentGatewayInterface;

class CreditCardGateway implements PaymentGatewayInterface
{
    protected $api_key;
    protected $secret_key;

    function __construct()
    {
        $this->api_key = env('CREDIT_CARD_API_KEY');
        $this->secret_key = env('CREDIT_CARD_SECRET_KEY');
    }

    public function processPayment(Payment $payment)
    {
        $payment->status = PaymentStatusEnum::SUCCESSFUL->value; // Mock response
        $payment->payment_id = 'CC-' . uniqid();
        $payment->save();

        return $payment;
    }
}
