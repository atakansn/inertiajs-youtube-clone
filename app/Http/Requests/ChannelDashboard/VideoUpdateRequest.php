<?php

namespace App\Http\Requests\ChannelDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class VideoUpdateRequest extends FormRequest
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
            'title' => 'string',
            'description' => 'string',
            'thumbnail' => 'mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }
}
