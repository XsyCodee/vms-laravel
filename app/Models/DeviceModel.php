<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceModel extends Model
{
    protected $fillable = ['brand', 'model_name', 'equipment_type', 'u_size', 'port_count', 'requires_serial_number', 'power_draw_w'];
    public function equipments(): HasMany { return $this->hasMany(RackEquipment::class); }
}
