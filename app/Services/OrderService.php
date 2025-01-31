<?php

namespace App\Services;

use App\DTOs\LoginRequestDTO;
use App\DTOs\RegisterRequestDTO;
use App\DTOs\StoreOrderRequestDTO;
use App\DTOs\UpdateOrderRequestDTO;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderService
{

  function list(array $filters = [])
  {
    $orders = Order::query()->with(['items'])
      ->when(Arr::get($filters, 'status', false), function ($query) use ($filters) {
        return $query->where('status', Arr::get($filters, 'status'));
      })->paginate(20);
    return [
      OrderResource::collection($orders)->response()->getData(true)
    ];
  }

  function createOrder(StoreOrderRequestDTO $request)
  {
    $items = collect($request->items);
    $total_amount = $this->calculateTotal($request->items);
    $user = auth()->user();
    $order = $user->orders()->create([
      'user_name' => $request->user_name,
      'user_email' => $request->user_email,
      'total_amount' => $total_amount
    ]);
    $items->map(function ($item) use ($order) {
      $order->items()->create([
        'product_name' => $item['product_name'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
      ]);
    });
    return [
      'data' => new OrderResource($order)
    ];
  }

  function show(Order $order)
  {
    return [
      'data' => new OrderResource($order)
    ];
  }

  function updateOrder(UpdateOrderRequestDTO $request, Order $order)
  {
    $order->update(['status' => $request->status]);
    return [
      'data' => new OrderResource($order)
    ];
  }

  function deleteOrder(Order $order)
  {
    $order->delete();
    return true;
  }

  private function calculateTotal($items)
  {
    $total_price = collect($items)->map(function ($item) {
      return $item['quantity'] * $item['price'];
    })->sum();
    return $total_price;
  }
}
