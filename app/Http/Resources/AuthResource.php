<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,

            'profile' => [
                'first_name' => $this->profile->first_name,
                'last_name' => $this->profile->last_name,
                'phone' => $this->profile->phone,
                'job_title' => $this->profile->job_title,
                'company' => $this->profile->company,
                'industry' => $this->profile->industry,
                'website' => $this->profile->website,
                'bio' => $this->profile->bio,
                'linked_in_profile' => $this->profile->linked_in_profile,
            ],

            'travel' => [
                'nationality' => $this->travelDetail->nationality,
                'country' => $this->travelDetail->country,
                'arrival_date' => $this->travelDetail->arrival_date,
                'arrival_time' => $this->travelDetail->arrival_time,
                'departure_date' => $this->travelDetail->departure_date,
                'departure_time' => $this->travelDetail->departure_time,

                // ❌ ما نرجعش path مباشر
                'has_passport' => !empty($this->travelDetail->passport_image),
            ],

            'timezone' => $this->timezone,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
        ];
    }
}
