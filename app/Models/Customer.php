<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    protected $fillable = ['name', 'code', 'contact_email', 'contact_phone'];
    public function racks(): HasMany { return $this->hasMany(Rack::class); }
    public function users(): HasMany { return $this->hasMany(User::class); }
    public function permits(): HasMany { return $this->hasMany(VisitPermit::class); }
    public function icRequests(): HasMany { return $this->hasMany(InterconnectionRequest::class); }
    public function rackEquipments(): HasMany { return $this->hasMany(RackEquipment::class); }
    public function rackTenants(): HasMany { return $this->hasMany(RackTenant::class); }
}
