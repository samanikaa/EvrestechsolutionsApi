<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $table='users';

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
