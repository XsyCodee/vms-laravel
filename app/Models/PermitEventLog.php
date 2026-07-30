<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PermitEventLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['permit_id', 'status', 'message', 'timestamp'];
    protected $casts = ['timestamp' => 'datetime'];
    public function permit(): BelongsTo { return $this->belongsTo(VisitPermit::class, 'permit_id'); }
}
