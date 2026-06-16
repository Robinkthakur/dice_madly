<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'contact_limit',
        'interest_limit',
        'chat_access',
        'view_contact',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'contact_limit' => 'integer',
        'interest_limit' => 'integer',
        'chat_access' => 'boolean',
        'view_contact' => 'boolean',
    ];
}
