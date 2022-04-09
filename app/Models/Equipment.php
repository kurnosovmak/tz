<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "equipments".
 *
 * @property integer $id
 * @property string $serial_number
 * @property string $note
 * @property integer $equipment_type_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Equipment extends Model
{
    use HasFactory,Filterable;

    protected $table = 'equipments';

    protected $fillable = ['serial_number', 'note', 'equipment_type_id'];
    protected $guarded = ['id'];

    /**
     * Get equipment type this equipment
     *
     * @return BelongsTo
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }


}
