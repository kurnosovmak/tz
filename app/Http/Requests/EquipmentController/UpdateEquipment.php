<?php

namespace App\Http\Requests\EquipmentController;

use App\Services\SerialNumberService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipment extends FormRequest
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
        $error = [
            'serial_number' => null,
            'equipment_type_id' => null,
        ];

        $type_id = $this->get('equipment_type_id');
        $sn = $this->get('serial_number');

        if ($type_id || $sn) {

            if (!$this->canSerialNumber($type_id, $sn)) {
                if ($type_id) {
                    $error['equipment_type_id'] = 'The equipment type mask does not match the serial number.';
                }
                if ($sn) {
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
                function ($attribute, $value, $fail) use ($error) {
                    if ($error['serial_number']) {
                        $fail($error['serial_number']);
                    }
                }
            ],
            'note' => 'string|min:3',
            'equipment_type_id' => [
                'integer',
                'exists:equipment_types,id',
                function ($attribute, $value, $fail) use ($error) {
                    if ($error['equipment_type_id']) {
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
    private function canSerialNumber(int|null $equipment_type_id, string|null $new_serial_number): bool
    {
        $type = $equipment_type_id ?? $this->equipment->equipment_type_id;
        $sn = $new_serial_number ?? $this->equipment->serial_number;

        return $this->serialNumberService->isValidSerialNumber($type, $sn);
    }
}
