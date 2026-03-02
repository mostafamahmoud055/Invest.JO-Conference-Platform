<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request, AnnouncementService $service)
    {
        $filters = $request->only(['per_page']);
        $data = $service->List($filters);   

        return $this->successResponse($data, 'Announcements retrieved successfully', 200);
    }

    public function show(Announcement $announcement)
    {
        return $this->successResponse($announcement, 'Announcement retrieved successfully', 200);
    }   
    public function store(CreateAnnouncementRequest $request, AnnouncementService $service)
    {
        $validated = $request->validated();
        $announcement = $service->create($validated);

        return $this->successResponse($announcement, 'Announcement created successfully', 201);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement, AnnouncementService $service)
    {
        $validated = $request->validated();

        $updated = $service->update($announcement, $validated);

        return $this->successResponse($updated, 'Announcement updated successfully', 200);
    }

    public function destroy(Announcement $announcement, AnnouncementService $service)
    {
        $service->delete($announcement);

        return $this->successResponse(message: 'Announcement deleted successfully', statusCode: 200);
    }
}