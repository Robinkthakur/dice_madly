<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerPreference extends Model
{
    use HasFactory;

    protected $table = 'partner_preferences';

    protected $fillable = [
        'user_id',
        'gender',
        'min_age',
        'max_age',
        'religion',
        'caste',
        'country',
        'min_income',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
