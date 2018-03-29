<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RedPrice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'screening_id' => $this->screening_id,
            'title' => $this->title,
            'value' => $this->value,
            'thumb' => asset(Storage::url($this->thumb)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
