<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegacyEquipmentRecord extends Model
{
    protected $fillable = ['rack_name', 'item_name', 'qty', 'weight', 'dimension', 'serial_number',
        'notes', 'arrival_date', 'is_active', 'rack_id'];

    protected $casts = ['is_active' => 'boolean', 'arrival_date' => 'datetime'];

    public function rack(): BelongsTo { return $this->belongsTo(Rack::class); }
}
