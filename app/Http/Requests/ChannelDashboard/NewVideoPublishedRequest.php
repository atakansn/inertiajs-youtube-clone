<?php

namespace App\Http\Requests\ChannelDashboard;

use Illuminate\Foundation\Http\FormRequest;

class NewVideoPublishedRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'is_published' => 'required|boolean'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->input('publishStatus')
        ]);
    }

    public function messages()
    {
        return [
            'title.required' => 'Bu alan zorunludur',
            'title.string' => 'Bu alan dizge olmalıdır',
            'description.required' => 'Bu alan zorunludur',
            'description.string' => 'Bu alan dizge olmalıdır',
            'is_published.required' => 'Bu alan zorunludur',
            'is_published.boolean' => 'Bu alan boolean bir değer olmalıdır',
        ];
    }
}
