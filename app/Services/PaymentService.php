<?php

namespace App\Services;

use App\DTOs\PaymentRequestDTO;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payments\PaymentGatewayFactory;
use Illuminate\Support\Arr;

class PaymentService
{

  function list(array $filters = [])
  {

    $payments = Payment::query()
      ->when(Arr::get($filters, 'status', false), function ($query) use ($filters) {
        return $query->where('status', Arr::get($filters, 'status'));
      })
      ->when(Arr::get($filters, 'order_id', false), function ($query) use ($filters) {
        return $query->where('order_id', Arr::get($filters, 'order_id'));
      })
      ->paginate(20);
    return [
      PaymentResource::collection($payments)->response()->getData(true)
    ];
  }

  function createPayment(Order $order, PaymentRequestDTO $request)
  {
    $payment = $order->payments()->create([
      'payment_method' => $request->payment_method->value,
      'status' => 'pending'
    ]);
    $gateway = PaymentGatewayFactory::create($request->payment_method->value);
    $payment = $gateway->processPayment($payment);
    return [
      'payment' => new PaymentResource($payment)
    ];
  }
}
