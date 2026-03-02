<?php

namespace App\Http\Requests;

use App\Models\MeetingBooking;
use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class BookMeetingHallRequest extends FormRequest
{
    use ApiValidationTrait;
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
            'hall_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $alreadyBooked = MeetingBooking::where('hall_id', $value)
                        ->where('requester_user_id', auth()->id())
                        ->exists();

                    if ($alreadyBooked) {
                        $fail('You already booked this hall.');
                    }
                },
            ],
            'meeting_type'    => 'required|in:G2B,B2B',
            'topic'           => 'required|string|max:255',
            'date'    => 'required|date|after:yesterday',
            'time'      => 'required|date_format:H:i',
        ];
    }
}
