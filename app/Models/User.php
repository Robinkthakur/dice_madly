<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'profile_id',
    'first_name',
    'last_name',
    'email',
    'phone',
    'email_verified_at',
    'phone_verified_at',
    'gender',
    'age',
    'marital_status',
    'is_active',
    'is_verified',
    'verified_until',
    'dob',
    'password',
    'profile_image',
    'onboarding_step',
    'daily_rolls_count',
    'last_roll_date',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'dob' => 'date',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'verified_until' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user profile record.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's education record.
     */
    public function education()
    {
        return $this->hasOne(Education::class);
    }

    /**
     * Get the user's occupation record.
     */
    public function occupation()
    {
        return $this->hasOne(Occupation::class);
    }

    /**
     * Get the user's verifications.
     */
    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    /**
     * Get the user's interest options.
     */
    public function interestOptions()
    {
        return $this->belongsToMany(InterestOption::class, 'user_interest_options', 'user_id', 'interest_option_id');
    }

    public function partnerPreferences()
    {
        return $this->hasOne(PartnerPreference::class);
    }

    public function sentInterests()
    {
        return $this->hasMany(Interest::class, 'sender_id');
    }

    public function receivedInterests()
    {
        return $this->hasMany(Interest::class, 'receiver_id');
    }

    public function matches()
    {
        return $this->hasMany(\App\Models\UserMatch::class, 'user_id');
    }

    public function conversationsAsUserOne()
    {
        return $this->hasMany(Conversation::class, 'user_one');
    }

    public function conversationsAsUserTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPremium(): bool
    {
        return $this->is_verified and $this->verified_until >= now()->toDateString();
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Calculate profile completion percentage.
     *
     * @return int
     */
    public function profileCompletionPercentage(): int
    {
        $profile = $this->relationLoaded('profile') ? $this->profile : $this->profile()->first();
        $education = $this->relationLoaded('education') ? $this->education : $this->education()->first();
        $occupation = $this->relationLoaded('occupation') ? $this->occupation : $this->occupation()->first();
        $hasInterests = $this->relationLoaded('interestOptions') 
            ? $this->interestOptions->isNotEmpty() 
            : $this->interestOptions()->exists();

        $fields = [
            'first_name' => !empty($this->first_name),
            'last_name' => !empty($this->last_name),
            'email' => !empty($this->email),
            'phone' => !empty($this->phone),
            'gender' => !empty($this->gender),
            'dob' => !empty($this->dob),
            'profile_image' => !empty($this->profile_image),
            'about_me' => !empty($profile?->about_me),
            'country' => !empty($profile?->country),
            'state' => !empty($profile?->state),
            'city' => !empty($profile?->city),
            'mother_tongue' => !empty($profile?->mother_tongue),
            'qualification' => !empty($education?->highest_qualification),
            'profession' => !empty($occupation?->occupation),
            'interests' => $hasInterests,
        ];

        $completed = count(array_filter($fields));
        $total = count($fields);

        return (int) round(($completed / $total) * 100);
    }
}
