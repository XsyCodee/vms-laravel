<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterconnectionRequest extends Model
{
    protected $fillable = ['ticket_number', 'requester_id', 'customer_id', 'service_type', 'service_sub_type',
        'interconnect_type', 'source_device', 'source_port', 'source_rack', 'source_tenant', 'dest_device',
        'dest_port', 'dest_rack', 'dest_tenant', 'connector_type', 'cable_label', 'cable_spec', 'media_type',
        'allocated_switch_id', 'allocated_port_name', 'logic_config', 'installation_notes', 'payment_status',
        'payment_notes', 'invoice_number', 'ewo_code_hsp', 'ewo_code_prodc', 'cid', 'status', 'reject_reason',
        'noc_logic_by_id', 'finance_by_id', 'noc_dc_by_id', 'logic_setup_by_id', 'noc_logic_at', 'payment_at',
        'noc_dc_start_at', 'installed_at', 'logic_setup_at', 'completed_at'];

    protected $casts = ['noc_logic_at' => 'datetime', 'payment_at' => 'datetime', 'noc_dc_start_at' => 'datetime',
        'installed_at' => 'datetime', 'logic_setup_at' => 'datetime', 'completed_at' => 'datetime'];

    public function requester(): BelongsTo { return $this->belongsTo(User::class, 'requester_id'); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function allocatedSwitch(): BelongsTo { return $this->belongsTo(LogicSwitch::class, 'allocated_switch_id'); }
    public function timeline(): HasMany { return $this->hasMany(RequestTimeline::class, 'request_id'); }
}
