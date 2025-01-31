<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Listing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'price',
        'revenue',
        'profit',
        'category',
        'location',
        'status',
        'years_in_business',
        'employees',
        'reason_for_selling',
        'contact_email',
        'phone_number',
        'website',
        'views',
        'featured',
        'video_url',
        'images',
        'sections'
    ];

    /**
     * Cast attributes to proper data types.
     */
    protected $casts = [
        'images' => 'array',   // JSON field
        'sections' => 'array', // JSON field
        'price' => 'decimal:2',
        'revenue' => 'decimal:2',
        'profit' => 'decimal:2',
        'years_in_business' => 'integer',
        'employees' => 'integer',
        'views' => 'integer',
        'featured' => 'boolean',
    ];

    /**
     * The data type of the primary key.
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * Boot method to assign UUIDs & default status.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Ensure 'status' defaults to 'active' if not set
            if (!$model->status) {
                $model->status = 'active';
            }
        });
    }

    /**
     * Get the user who owns the listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the address associated with the listing.
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
