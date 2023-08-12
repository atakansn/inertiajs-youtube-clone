<?php

namespace App\Http\Requests\ChannelDashboard;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
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
            'rawVideo' => [
                'required',
                $this->validateRawVideo(),
            ],
            'videoTitle' => [
                'max:100',
                'string'
            ]
        ];
    }

    private function validateRawVideo(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail) {
            $allowedMimeTypes = ['video/mp4'];
            $allowedExtensions = ['mp4'];

            $fileSize = $value->getSize();
            $fileMimeType = $value->getClientMimeType();
            $fileExtension = $value->getClientOriginalExtension();

            if($fileSize >= 30000000) {
                $fail('Dosya boyutu 30 MB\'dan küçük olmalıdır.');
            }

            if (
                !in_array($fileMimeType, $allowedMimeTypes) ||
                !in_array($fileExtension, $allowedExtensions)
            ) {
                $fail("Geçersiz dosya. Sadece .mp4 uzantılı video dosyaları kabul edilir.");
            }
        };
    }
}
