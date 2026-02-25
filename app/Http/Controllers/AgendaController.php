<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendaRequest;
use App\Http\Resources\AgendaResource;
use App\Models\Agenda;
use App\Services\AgendaService;
use App\Traits\ApiResponseTrait;

class AgendaController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AgendaService $agendaService
    ) {}

    public function index()
    {
        $result = $this->agendaService->listGroupedByDate();

        return $this->successResponse([
            AgendaResource::collection($result->flatten()),
        ], 'Agendas fetched successfully');
    }

    public function store(AgendaRequest $request)
    {
        $result = $this->agendaService->create($request->validated());

        return $this->successResponse([
            new AgendaResource($result),
        ], 'Agenda created successfully', 201);
    }

    public function update(AgendaRequest $request, string $id)
    {
        $agenda = Agenda::find($id);
        if (!$agenda) {
            return $this->errorResponse('Agenda not found', 404);
        }

        $result = $this->agendaService->update($agenda, $request->validated());

        return $this->successResponse([
            new AgendaResource($result),
        ], 'Agenda updated successfully');
    }

    public function destroy(String $id)
    {
        $agenda = Agenda::find($id);
        if (!$agenda) {
            return $this->errorResponse('Agenda not found', 404);
        }

        $this->agendaService->delete($agenda);

        return $this->successResponse([], 'Agenda deleted successfully');
    }
}
