<?php

namespace App\Http\Requests\EquipmentController;


use App\Services\SerialNumberService;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipment extends FormRequest
{
    protected $serialNumberService;

    public function __construct(SerialNumberService $serialNumberService)
    {
        $this->serialNumberService = $serialNumberService;

    }

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
        return [
            '*.serial_number' => 'required|string|min:3|unique:equipments,serial_number',
            '*.note' => 'string|min:3',
            '*.equipment_type_id' => 'required|integer|exists:equipment_types,id',
            function ($attribute, $value, $fail) {
                if (!$this->serialNumberService->isValidSerialNumber($value['equipment_type_id'], $value['serial_number'])) {
                    $fail('The serial number does not match the mask.');
                }
            },
        ];
    }
}
