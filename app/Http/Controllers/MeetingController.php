<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookMeetingHallRequest;
use App\Http\Resources\MeetingBookingResource;
use App\Services\MeetingBookingService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class MeetingController extends Controller
{

    use ApiResponseTrait;
    public function __construct(
        protected MeetingBookingService $service
    ) {}

    // public function availability(Request $request)
    // {
    //     return MeetingHall::where('meeting_type', $request->type)
    //         ->whereBetween('date', [$request->from, $request->to])
    //         ->where('status', 'open')
    //         ->get();
    // }
    public function index(Request $request, MeetingBookingService $service)
{
    $paginator = $service->index($request->all());

    return $this->successResponse($paginator, 'Meeting bookings retrieved successfully', 200);
}

    public function book(BookMeetingHallRequest $request)
    {
        $data = $request->validated();

        $booking = $this->service->bookHall($data);

        $bookingResource = new MeetingBookingResource($booking);

        return $this->successResponse($bookingResource, 'Meeting booked successfully', 201);
    }

    // public function cancel($id)
    // {
    //     $booking = MeetingBooking::where('id', $id)
    //         ->where('requester_user_id', auth()->id())
    //         ->firstOrFail();

    //     $this->service->cancel($booking);

    //     return response()->noContent();
    // }
}
