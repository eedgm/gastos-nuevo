<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'number' => ['required', 'max:255', 'string'],
            'type' => ['required', 'in:Ahorro,Corriente'],
            'owner' => ['nullable', 'max:255', 'string'],
            'bank_id' => ['required', 'exists:banks,id'],
            'description' => ['nullable', 'max:255', 'string'],
        ];
    }
}
