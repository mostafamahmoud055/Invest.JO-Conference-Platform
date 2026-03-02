<?php

namespace App\Services;
use App\Models\MeetingBooking;
use Illuminate\Support\Facades\DB;

class MeetingBookingService
{


    public function index(array $filters = [])
    {
        $query = MeetingBooking::query()
            ->with(['hall', 'user']);

        return $query->latest()
            ->simplePaginate($filters['per_page'] ?? 10);
    }
    public function bookHall(array $data): MeetingBooking
    {
        return DB::transaction(function () use ($data) {

            $booking = MeetingBooking::create([
                'hall_id' => $data['hall_id'],
                'date' => $data['date'] ?? now(),
                'time' => $data['time'] ?? now()->addHour(),
                'booked_count' => 0,
                'requester_user_id' => auth()->id(),
                'meeting_type' => $data['meeting_type'],
                'topic' => $data['topic'],
                'status' => 'confirmed',
            ]);

            // if (! $meetingHall->isAvailable()) {
            //     throw ValidationException::withMessages([
            //         'hall' => 'This meeting hall is no longer available.'
            //     ]);
            // }

            $booking->increment('booked_count');

            return $booking->load('hall', 'user');
        });
    }

    // public function cancel(MeetingBooking $booking): void
    // {
    //     DB::transaction(function () use ($booking) {

    //         if ($booking->status !== 'confirmed') {
    //             return;
    //         }

    //         $hall = MeetingHall::where('id', $booking->meeting_hall_id)
    //             ->lockForUpdate()
    //             ->first();

    //         $booking->update(['status' => 'cancelled']);
    //         $hall->decrement('booked_count');
    //     });
    // }
}
