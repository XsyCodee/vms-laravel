<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EquipmentPort extends Model
{
    protected $fillable = ['equipment_id', 'port_name'];
    public function equipment(): BelongsTo { return $this->belongsTo(RackEquipment::class, 'equipment_id'); }
}
