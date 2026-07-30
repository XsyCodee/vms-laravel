<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VisitPermit extends Model
{
    protected $fillable = ['datacenter_id', 'customer_id', 'company_name', 'visitor_names', 'visitor_photo',
        'activity', 'scheduled_at', 'check_in_at', 'check_out_at', 'status', 'approved_by_id',
        'nda_signed_at', 'qr_code_token', 'requires_escort', 'zone_access', 'collateral_type',
        'collateral_name', 'collateral_id'];

    protected $casts = ['scheduled_at' => 'datetime', 'check_in_at' => 'datetime', 'check_out_at' => 'datetime',
        'nda_signed_at' => 'datetime', 'requires_escort' => 'boolean'];

    public function datacenter(): BelongsTo { return $this->belongsTo(Datacenter::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(User::class, 'approved_by_id'); }
    public function accessCard(): HasOne { return $this->hasOne(AccessCard::class, 'current_permit_id'); }
    public function eventLogs(): HasMany { return $this->hasMany(PermitEventLog::class, 'permit_id'); }
}
