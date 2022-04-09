<?php


namespace App\Http\Filters;


use Carbon\Carbon;

class EquipmentFilter extends QueryFilter
{

    /**
     * @param string $text
     */
    public function search(string $text)
    {
        $this->builder->where(function($query) use($text){
            $query->where('serial_number','LIKE',"%$text%");
            $query->orWhere('note','LIKE',"%$text%");
        });
    }

    /**
     * @param int $equipment_type_id
     */
    public function equipment_type_id(int $equipment_type_id)
    {
        $this->builder->where('equipment_type_id',$equipment_type_id);
    }




}
