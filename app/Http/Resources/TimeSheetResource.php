<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeSheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'task_name' => $this->task_name,
            'date' => $this->date,
            'hours' => $this->hours,
            'project' => ProjectResource::make($this->whenLoaded('project')),
        ];
    }
}
