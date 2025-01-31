<?php

namespace App\Http\Requests;

use App\DTOs\StoreOrderRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class StoreOrderRequest extends FormRequest
{
    use WithData;

    protected string $dataClass =StoreOrderRequestDTO::class;
    
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
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'items' => 'required|array',
            'items.*' => 'required|array',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ];
    }
}
