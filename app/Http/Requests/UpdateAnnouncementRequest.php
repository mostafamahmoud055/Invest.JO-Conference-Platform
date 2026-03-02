<?php

namespace App\Http\Requests;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest extends FormRequest
{
    use ApiValidationTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['sometimes', 'string', 'max:255'],
            'body'         => ['sometimes', 'string'],
            'image'    => ['nullable', 'image', 'max:500', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
