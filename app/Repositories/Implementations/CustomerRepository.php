<?php

namespace App\Repositories\Implementations;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerInterface;

class CustomerRepository extends BaseRepository implements CustomerInterface
{
    
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}
