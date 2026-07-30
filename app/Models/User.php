<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = ['email', 'name', 'password', 'role_id', 'datacenter_id', 'customer_id'];
    protected $hidden = ['password', 'remember_token'];

    public function role(): BelongsTo { return $this->belongsTo(Role::class); }
    public function datacenter(): BelongsTo { return $this->belongsTo(Datacenter::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function permissions(): BelongsToMany { return $this->belongsToMany(Permission::class, 'user_permission'); }
    public function auditLogs(): HasMany { return $this->hasMany(SystemAuditLog::class); }
    public function permitsApproved(): HasMany { return $this->hasMany(VisitPermit::class, 'approved_by_id'); }
    public function icRequests(): HasMany { return $this->hasMany(InterconnectionRequest::class, 'requester_id'); }
    public function equipmentAssignments(): HasMany { return $this->hasMany(RackEquipment::class, 'petugas_id'); }

    public function isSuperAdmin(): bool { return strtolower(str_replace(' ', '', $this->role?->name ?? '')) === 'superadmin'; }
    public function isAdmin(): bool { return in_array(strtolower(str_replace(' ', '', $this->role?->name ?? '')), ['superadmin', 'nocadmin', 'nocstaff']); }
    public function isCustomer(): bool { return strtolower($this->role?->name ?? '') === 'customer' || str_contains(strtolower($this->role?->name ?? ''), 'tenant'); }
}
