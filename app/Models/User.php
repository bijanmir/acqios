<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'is_premium',
        'premium_expires_at',
        'subscription_id',
        'subscription_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'premium_expires_at' => 'datetime',
        'is_premium' => 'boolean',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function savedListings()
    {
        return $this->belongsToMany(Listing::class, 'listing_saves')->withTimestamps();
    }

    /**
     * Check if the user has an active premium subscription
     *
     * @return bool
     */
    public function isPremium(): bool
    {
        // Check if is_premium flag is true AND (if expiration date exists) that it hasn't passed
        return $this->is_premium &&
            ($this->premium_expires_at === null || $this->premium_expires_at > Carbon::now());
    }

    /**
     * Make a user premium
     *
     * @param int $months Number of months to add to subscription
     * @param string|null $subscriptionId External subscription ID (if using payment gateway)
     * @return void
     */
    public function subscribeToPremium(int $months = 1, ?string $subscriptionId = null): void
    {
        $expiresAt = $this->premium_expires_at;

        // If user already has an active subscription, extend it
        if ($expiresAt && $expiresAt > Carbon::now()) {
            $expiresAt = $expiresAt->addMonths($months);
        } else {
            // Otherwise set new expiration date
            $expiresAt = Carbon::now()->addMonths($months);
        }

        $this->is_premium = true;
        $this->premium_expires_at = $expiresAt;

        if ($subscriptionId) {
            $this->subscription_id = $subscriptionId;
            $this->subscription_status = 'active';
        }

        $this->save();
    }

    /**
     * Cancel a user's premium subscription
     *
     * @param bool $immediately Whether to end premium access immediately or at expiration
     * @return void
     */
    public function cancelPremium(bool $immediately = false): void
    {
        // Immediately delete the account
        $immediately = true;
        if ($immediately) {
            $this->is_premium = false;
            $this->premium_expires_at = null;
        }

        $this->subscription_status = 'cancelled';
        $this->save();
    }

    /**
     * Check if premium is expiring soon (within 7 days)
     *
     * @return bool
     */
    public function isPremiumExpiringSoon(): bool
    {
        if (!$this->isPremium() || !$this->premium_expires_at) {
            return false;
        }

        return $this->premium_expires_at->diffInDays(Carbon::now()) <= 7;
    }
}
