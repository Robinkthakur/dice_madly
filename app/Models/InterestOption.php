<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InterestOption extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'interest_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
    ];

    /**
     * The users that have selected this interest.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_interest_options', 'interest_option_id', 'user_id');
    }
}
