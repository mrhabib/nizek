<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomDateChangeRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
    public function prepareForValidation()
    {
        if ($this->route('company_name')) {
            $this->merge(['company_name' => $this->route('company_name')]);
        }
    }
}
