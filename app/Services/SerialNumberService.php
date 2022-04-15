<?php


namespace App\Services;


use App\Models\EquipmentType;

class SerialNumberService
{
    /**
     * Checks the new number by mask
     *
     * @param integer $equipment_type_id
     * @param string $new_serial_number
     * @return bool
     */
    public function isValidSerialNumber(int $equipment_type_id, string $new_serial_number): bool
    {
        $type = EquipmentType::find($equipment_type_id);
        if (!$type || strlen($new_serial_number) != strlen($type->serial_number_mask)) {
            return false;
        }
        $ger = self::generateRegExpByMask($type->serial_number_mask);


        return preg_match($ger, $new_serial_number) == false ? false : true;
    }

    /**
     * Generate preg string
     *
     * @param string $mask
     * @return string
     */
    private function generateRegExpByMask(string $mask): string
    {
        $mask = str_split($mask);
        $ger = '/';
        foreach ($mask as $char) {
            switch ($char) {
                case 'N':
                    $ger .= '[0-9]';
                    break;
                case 'X':
                    $ger .= '[A-Z0-9]';
                    break;
                case 'A':
                    $ger .= '[A-Z]';
                    break;
                case 'a':
                    $ger .= '[a-z]';
                    break;
                case 'Z':
                    $ger .= '(\\-|\\@|\\_)';
                    break;
            }
        }
        $ger .= '/';
        return $ger;
    }
}
