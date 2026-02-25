<?php

namespace App\Services;

use App\Models\Agenda;

class AgendaService
{
    public function listGroupedByDate()
    {
        return Agenda::query()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($item) => $item->date->format('Y-m-d'));
    }

    public function create(array $data): Agenda
    {
        return Agenda::create($data);
    }

    public function update(Agenda $agenda, array $data): Agenda
    {
        $agenda->update($data);
        return $agenda->refresh();
    }

    public function delete(Agenda $agenda): void
    {
        $agenda->delete();
    }
}