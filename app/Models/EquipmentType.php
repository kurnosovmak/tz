<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "equipment_types".
 *
 * @property integer $id
 * @property string $name
 * @property string $serial_number_mask
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class EquipmentType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'serial_number_mask'];

    protected $guarded = ['id'];

   /**
     * Get equipments who has this equipment type
     *
     * @return HasMany
     */
    public function equipmentType(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }


}
