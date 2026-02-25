<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgendaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'start_time' => $this->start_time?->format('H:i'),
            'end_time' => $this->end_time?->format('H:i'),
            'duration' => $this->duration,
            'title' => $this->title,
            'speaker' => $this->speaker,
            'hall' => $this->hall,
            'industry' => $this->industry,
            'type' => $this->type,
        ];
    }
}