<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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

            'website' => 'required|url|max:255',
            'nationality' => 'required|string|max:255',
            'national_id' => [
                'required_if:nationality,Jordanian',
                'nullable',
                'string',
                'max:255',
                'unique:user_profiles,national_id',
            ],
            'passport_image' => [
                'required_if:nationality,European',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'bio' => 'nullable|string',
            'linked_in_profile' => 'nullable|url|max:255',
            'arrival_date' => ['nullable', 'date', 'after:yesterday'],
            'arrival_time' => ['nullable', 'date_format:H:i'],

            'departure_date' => ['nullable', 'date'],
            'departure_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // تحقق أولاً إن كل الحقول موجودة
            if ($this->arrival_date && $this->arrival_time && $this->departure_date && $this->departure_time) {

                try {
                    $arrival = Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $this->arrival_date . ' ' . $this->arrival_time
                    );

                    $departure = Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $this->departure_date . ' ' . $this->departure_time
                    );

                    // 1️⃣ Departure must be after arrival
                    if ($departure->lte($arrival)) {
                        $validator->errors()->add(
                            'departure_time',
                            'Departure datetime must be greater than arrival datetime.'
                        );
                    }

                    // 2️⃣ Arrival must not be in the past
                    if ($arrival->lte(now())) {
                        $validator->errors()->add(
                            'arrival_time',
                            'Arrival datetime must be in the future.'
                        );
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add(
                        'arrival_time',
                        'Arrival or departure datetime format is invalid.'
                    );
                }
            }
        });
    }
}
