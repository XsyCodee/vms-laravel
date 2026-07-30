<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rack extends Model
{
    protected $fillable = ['row_id', 'customer_id', 'name', 'u_capacity', 'type', 'status'];

    public function row(): BelongsTo { return $this->belongsTo(Row::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function equipments(): HasMany { return $this->hasMany(RackEquipment::class); }
    public function tenants(): HasMany { return $this->hasMany(RackTenant::class); }
    public function legacyEquipment(): HasMany { return $this->hasMany(LegacyEquipmentRecord::class); }
    public function vendorMaintenances(): BelongsToMany { return $this->belongsToMany(VendorMaintenance::class, 'maintenance_affected_racks'); }
}
