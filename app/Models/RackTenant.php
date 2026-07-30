<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RackTenant extends Model
{
    protected $fillable = ['rack_id', 'customer_id', 'u_size', 'status', 'notes'];
    public function rack(): BelongsTo { return $this->belongsTo(Rack::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
}
