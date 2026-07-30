<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataRoom extends Model
{
    protected $fillable = ['floor_id', 'name'];
    protected $table = 'data_rooms';
    public function floor(): BelongsTo { return $this->belongsTo(Floor::class); }
    public function containments(): HasMany { return $this->hasMany(Row::class, 'room_id'); }
}
