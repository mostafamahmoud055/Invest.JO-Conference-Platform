<?php

namespace App\Http\Requests;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateAnnouncementRequest extends FormRequest
{

    use ApiValidationTrait;
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'body'        => ['required', 'string'],
            'image'   => ['nullable', 'image', 'max:500', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
