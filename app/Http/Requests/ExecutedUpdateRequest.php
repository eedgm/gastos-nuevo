<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutedUpdateRequest extends FormRequest
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
            'cost' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'expense_id' => ['required', 'exists:expenses,id'],
            'type_id' => ['required', 'exists:types,id'],
        ];
    }
}
