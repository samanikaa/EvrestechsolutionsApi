<?php

namespace App\Repositories\Implementations;

use App\Models\SalesOrder;
use App\Repositories\Contracts\SalesOrderInterface;

class SalesOrderRepository extends BaseRepository implements SalesOrderInterface
{

    public function __construct(SalesOrder $model)
    {
        parent::__construct($model);
    }
}
