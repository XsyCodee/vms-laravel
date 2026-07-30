<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RackEquipment extends Model
{
    protected $table = 'rack_equipments';

    protected $fillable = ['rack_id', 'customer_id', 'name', 'equipment_type', 'u_start', 'u_end',
        'orientation', 'status', 'arrival_date', 'departure_date', 'serial_number', 'asset_tag',
        'weight', 'device_model_id', 'petugas_id'];

    public function rack(): BelongsTo { return $this->belongsTo(Rack::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function deviceModel(): BelongsTo { return $this->belongsTo(DeviceModel::class); }
    public function petugas(): BelongsTo { return $this->belongsTo(User::class, 'petugas_id'); }
    public function ports(): HasMany { return $this->hasMany(EquipmentPort::class, 'equipment_id'); }
    public function auditLogs(): HasMany { return $this->hasMany(InfrastructureAuditLog::class, 'equipment_id'); }
}
