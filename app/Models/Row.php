<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Row extends Model
{
    protected $fillable = ['room_id', 'name'];
    public function dataHall(): BelongsTo { return $this->belongsTo(DataRoom::class, 'room_id'); }
    public function racks(): HasMany { return $this->hasMany(Rack::class); }
}
