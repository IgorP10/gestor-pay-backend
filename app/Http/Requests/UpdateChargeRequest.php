<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChargeRequest extends FormRequest
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
        'organization_id' => 'sometimes|exists:organizations,id',
        'description' => 'sometimes|string|max:255',
        'amount' => 'sometimes|numeric|min:0',
        'due_date' => 'sometimes|date',
        'status' => 'sometimes|in:pending,paid',
        'payment_date' => 'nullable|date',
    ];
    }
}
