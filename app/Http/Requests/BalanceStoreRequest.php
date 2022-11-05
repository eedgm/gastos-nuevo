<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'account_id' => ['required', 'exists:accounts,id'],
            'description' => ['nullable', 'string'],
            'total' => ['nullable', 'numeric'],
            'reported' => ['nullable', 'boolean'],
        ];
    }
}
