<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Occupation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'occupations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'occupation',
        'company',
        'annual_income',
    ];

    /**
     * Get the user that owns the occupation record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
