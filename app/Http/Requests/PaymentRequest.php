<?php

namespace App\Http\Requests;

use App\DTOs\PaymentRequestDTO;
use App\Enums\PaymentGatewaysEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class PaymentRequest extends FormRequest
{
    use WithData;

    protected string $dataClass =PaymentRequestDTO::class;
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
            'payment_method' => ['required', 'string', 'in:'.implode(',',array_column(PaymentGatewaysEnum::cases(),'value'))]
        ];
    }
}
