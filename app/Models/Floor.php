<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    protected $fillable = ['datacenter_id', 'name'];
    public function datacenter(): BelongsTo { return $this->belongsTo(Datacenter::class); }
    public function dataHalls(): HasMany { return $this->hasMany(DataRoom::class); }
}
