<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'idea' => 'required|string|min:5|max:30',
            'description' => 'required|string|min:5|max:255',
            'type' => 'required|string|in:service,project,product',
            'category' => 'required|string|min:3|max:10',
            'location' => 'required|string|max:2',
            'target_audience' => 'required|string|in:B2B,B2C,other',
            'revenue_model' => 'required|string|in:subscribe,sale,free',
            'keywords' => 'nullable|min:2|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'min' => 'هذا الحقل قصير للغاية',
            'max' => 'هذا الحقل اطول مما ينبغي',
            'string' => 'يجب أن يحتوي هذا الحقل على نص',
        ];
    }
}
