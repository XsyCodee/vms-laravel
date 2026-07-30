<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Datacenter extends Model
{
    protected $fillable = ['region_id', 'code', 'name', 'noc_email'];
    public function region(): BelongsTo { return $this->belongsTo(Region::class); }
    public function floors(): HasMany { return $this->hasMany(Floor::class); }
    public function goods(): HasMany { return $this->hasMany(GoodsItem::class); }
    public function permits(): HasMany { return $this->hasMany(VisitPermit::class); }
    public function mailConfig(): HasOne { return $this->hasOne(DatacenterMailConfig::class); }
    public function interconnectionProviders(): HasMany { return $this->hasMany(InterconnectionProvider::class); }
}
