<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseUpdateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'date_to' => ['nullable', 'date'],
            'budget' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'cluster_id' => ['required', 'exists:clusters,id'],
            'assign_id' => ['required', 'exists:assigns,id'],
            'account_id' => ['required', 'exists:accounts,id'],
            'google_calendar' => ['nullable', 'boolean'],
        ];
    }
}
