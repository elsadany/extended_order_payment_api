<?php

namespace App\Http\Requests;

use App\DTOs\UpdateOrderRequestDTO;
use App\Enums\OrdersStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class UpdateOrderRequest extends FormRequest
{
    use WithData;

    protected string $dataClass =UpdateOrderRequestDTO::class;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', 'in:'.implode(',',array_column(OrdersStatusEnum::cases(),'value'))]
        ];
    }
}
