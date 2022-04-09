<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class EquipmentJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'serial_number'=>$this->serial_number,
            'note'=>$this->note,
            'equipment_type'=>(new EquipmentTypeJson($this->equipmentType))->toArray($request),
            'created_at'=>Carbon::make($this->created_at)->format('d.m.Y'),
        ];
    }
}
