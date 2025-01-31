<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrdersStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListOrdersRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct(protected readonly OrderService $order_service) {}


    //get alluser orders request
    function index(ListOrdersRequest $request)
    {
        $data = $this->order_service->list($request->validated());

        return apiResponse()->data(data: $data, message: 'returned Successfully');
    }

    //
    function store(StoreOrderRequest $request)
    {

        $data = $this->order_service->createOrder($request->getData());

        return apiResponse()->data(data: $data, message: 'stored Successfully');
    }

    function show(Order $order)
    {
        $data = $this->order_service->show($order);

        return apiResponse()->data(data: $data, message: 'return Successfully');
    }

    function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $this->order_service->updateOrder($request->getData(), $order);
        return apiResponse()->data(data: $data, message: 'updated Successfully');
    }

    function destroy(Order $order)
    {
        if ($order->payments()->count()) {
            return apiResponse()->respond(errors: ['can`t delete'], status: 401, errorCode: 'CD');
        }
        $this->order_service->deleteOrder($order);
        return apiResponse()->data(data: null, message: 'deleted Successfully');

    }
}
