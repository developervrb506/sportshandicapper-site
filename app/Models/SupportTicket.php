<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_system',
        'external_id',
        'customer_name',
        'customer_email',
        'subject',
        'message',
        'status',
        'priority',
        'legacy_created_at',
        'legacy_updated_at',
    ];

    protected $casts = [
        'legacy_created_at' => 'datetime',
        'legacy_updated_at' => 'datetime',
        'priority' => 'integer',
    ];
}
