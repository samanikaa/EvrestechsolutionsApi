<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $table='users';

    /**
     * type -> // 'customer', 'employee'
     */
    protected $fillable = [
        'id',
        'type',
        'name',
        'email',
        'password',
        'phone',
        'billingaddress',
        'shippingaddress',
    ];
}
