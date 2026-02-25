<?php

namespace App\Http\Requests\Auth;

use App\Rules\FullNameRequiredForJordanian;
use App\Rules\NationalIdRequiredForJordanian;
use App\Rules\PassportRequiredForEuropean;
use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ApiValidationTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => ['required_if:nationality,Jordanian', 'string', 'max:255'],
            'family_name' => ['required_if:nationality,Jordanian', 'string', 'max:255'],
            'phone' => 'nullable|string|max:20',
            'job_title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'required|url|max:255',
            'nationality' => 'required|in:Jordanian,European',
            'national_id' => [
                    'required_if:nationality,Jordanian',
                'nullable',
                'string',
                'max:255',
                'unique:user_profiles,national_id',
            ],
            'country' => 'required|string|max:255',
            'passport_image' => [
                'required_if:nationality,European',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'bio' => 'nullable|string',
            'linked_in_profile' => 'nullable|url|max:255',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|date_format:H:i',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
        ];
    }
}
