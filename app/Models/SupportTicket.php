<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    protected $fillable = ['customer_id', 'reporter_id', 'assignee_id', 'datacenter_id', 'subject',
        'description', 'priority', 'status', 'category', 'sla_downtime_mins', 'resolved_at'];

    protected $casts = ['resolved_at' => 'datetime'];

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function reporter(): BelongsTo { return $this->belongsTo(User::class, 'reporter_id'); }
    public function assignee(): BelongsTo { return $this->belongsTo(User::class, 'assignee_id'); }
    public function datacenter(): BelongsTo { return $this->belongsTo(Datacenter::class); }
    public function comments(): HasMany { return $this->hasMany(TicketComment::class, 'ticket_id'); }
}
