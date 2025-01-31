<?php

namespace App\Http\Requests;

use App\Enums\PaymentGatewaysEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ListPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'page'    => ['nullable', 'integer','gte:1'],
            'status' => ['nullable', 'string', 'in:'.implode(',',array_column(PaymentStatusEnum::cases(),'value'))],
            'order_id' => ['nullable', 'integer', 'exists:orders,id']
        ];
    }
}
