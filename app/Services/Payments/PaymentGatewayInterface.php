<?php

namespace App\Services\Payments;

use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function processPayment(Payment $payment);
}
