<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_SELLER = 3;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if the user is a regular user
     */
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    /**
     * Check if the user is a seller
     */
    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Products owned by the user (when seller).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Orders created by the user (as buyer).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Orders received by the user (as seller).
     */
    public function receivedOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }
}
