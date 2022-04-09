<?php

namespace App\Http\Requests\EquipmentController;

use App\Services\SerialNumberService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $error = [
            'serial_number'=>null,
            'equipment_type_id'=>null,
        ];

        $eti = $this->get('equipment_type_id');
        $sn = $this->get('serial_number');

        if($eti || $sn){
            if(!$this->canSerialNumber($eti,$sn)){
                if($eti){
                    $error['equipment_type_id'] = 'The equipment type mask does not match the serial number.';
                }
                if($sn){
                    $error['serial_number'] = 'The serial number does not match the mask.';
                }
            }
        }

        return [
            'serial_number' => [
                'required_with:equipment_type_id',
                'string',
                'min:3',
                'unique:equipments,serial_number',
                function($attribute,$value,$fail) use($error){
                    if($error['serial_number'])
                    {
                        $fail($error['serial_number']);
                    }
                }
            ],
            'note' => 'string|min:3',
            'equipment_type_id' => [
                'integer',
                'exists:equipment_types,id',
                function($attribute,$value,$fail) use ($error){
                    if($error['equipment_type_id'])
                    {
                        $fail($error['equipment_type_id']);
                    }
                }
            ],

        ];
    }

    /**
     * Checks whether the mask and serial number are suitable.
     *
     * @param int|null $equipment_type_id
     * @param string|null $new_serial_number
     * @return bool
     */
    private function canSerialNumber(int|null $equipment_type_id,string|null $new_serial_number): bool
    {
        $eti = $equipment_type_id??$this->equipment->equipment_type_id;
        $sn = $new_serial_number??$this->equipment->serial_number;

        return SerialNumberService::canSerialNumber($eti,$sn);
    }
}
