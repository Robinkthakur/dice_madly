<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanionRental extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companion_rentals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_no',
        'type',
        'name',
        'email',
        'phone',
        'gender',
        'rent_target',
        'age',
        'city',
        'duration_hours',
        'budget_or_rate',
        'hobbies_interests',
        'partner_experience',
        'remarks',
        'status',
        'ip_address',
        'user_agent',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope for clients looking to rent.
     */
    public function scopeClients($query)
    {
        return $query->where('type', 'client');
    }

    /**
     * Scope for registered rental partners.
     */
    public function scopePartners($query)
    {
        return $query->where('type', 'partner');
    }

    /**
     * Scope by target companion type (boyfriend or girlfriend).
     */
    public function scopeForBoyfriend($query)
    {
        return $query->where('rent_target', 'boyfriend');
    }

    public function scopeForGirlfriend($query)
    {
        return $query->where('rent_target', 'girlfriend');
    }

    /**
     * Scope by status.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Human readable type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'partner' ? 'Rental Partner (Provider)' : 'Client (Looking to Rent)';
    }

    /**
     * Human readable rent target label.
     */
    public function getRentTargetLabelAttribute(): string
    {
        return match ($this->rent_target) {
            'boyfriend' => 'Boyfriend Companion',
            'girlfriend' => 'Girlfriend Companion',
            default => 'Both / Flexible',
        };
    }
}
