<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListPaymentRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function __construct(protected readonly PaymentService $payment_service) {}

    function index(ListPaymentRequest $request) {
        $data = $this->payment_service->list($request->validated());
        return apiResponse()->data(data: $data, message: 'returned Successfully');

    }

    function store(Order $order, PaymentRequest $request)
    {
        $data = $this->payment_service->createPayment($order, $request->getData());
        return apiResponse()->data(data: $data, message: 'payed Successfully');
    }
}
