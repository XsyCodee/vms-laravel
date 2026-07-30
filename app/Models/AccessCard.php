<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessCard extends Model
{
    protected $fillable = ['card_number', 'status', 'current_permit_id'];
    public function currentPermit(): BelongsTo { return $this->belongsTo(VisitPermit::class, 'current_permit_id'); }
}
