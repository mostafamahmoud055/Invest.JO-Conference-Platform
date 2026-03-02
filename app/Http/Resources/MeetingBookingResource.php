<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'requester_user_id' => $this->requester_user_id,
            'meeting_type' => $this->meeting_type,
            'topic' => $this->topic,
            'date' => $this->date,
            'time' => $this->time,
            'booked_count' => $this->booked_count,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Hall relation
            'hall' => [
                'id' => $this->hall?->id,
                'name' => $this->hall?->name,
                'created_at' => $this->hall?->created_at,
                'updated_at' => $this->hall?->updated_at,
            ],

            // User relation
            'user' => [
                'id' => $this->user?->id,
                'email' => $this->user?->email,
                'role' => $this->user?->role,
                'status' => $this->user?->status,
                'timezone' => $this->user?->timezone,
                'email_verified_at' => $this->user?->email_verified_at,
                'created_at' => $this->user?->created_at,
                'updated_at' => $this->user?->updated_at,
            ],
        ];
    }
}
