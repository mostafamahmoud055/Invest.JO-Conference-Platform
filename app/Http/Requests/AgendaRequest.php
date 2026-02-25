<?php

namespace App\Http\Requests;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;


class AgendaRequest extends FormRequest
{
    use ApiValidationTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'title' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'hall' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
        ];
    }
}
