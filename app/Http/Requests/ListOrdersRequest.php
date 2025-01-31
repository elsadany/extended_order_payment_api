<?php

namespace App\Http\Requests;

use App\DTOs\ListOrdersRequestDTO;
use App\Enums\OrdersStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;

class ListOrdersRequest extends FormRequest
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
            'status' => ['nullable', 'string', 'in:'.implode(',',array_column(OrdersStatusEnum::cases(),'value'))]
        ];
    }
}
