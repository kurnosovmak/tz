<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class EquipmentTypesSeeder extends Seeder
{
    const EquipmentTypes = [
        [
            'name'=>'TP-Link TL-WR74',
            'serial_number_mask'=>'XXAAAAAXAA',
        ],
        [
            'name'=>'D-Link DIR-300',
            'serial_number_mask'=>'NXXAAXZXaa',
        ],
        [
            'name'=>'D-Link DIR-300 S',
            'serial_number_mask'=>'NXXAAXZXXX',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = EquipmentType::count();
        if($count < 1){
            foreach (self::EquipmentTypes as $equipment_type) {
                EquipmentType::create([
                    'name' => $equipment_type['name'],
                    'serial_number_mask' => $equipment_type['serial_number_mask'],
                ]);
            }
        }
    }
}
