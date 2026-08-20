<?php

namespace App\Repositories\Implementations;

use App\Models\SalesOrderLine;
use App\Repositories\Contracts\SalesOrderLineInterface;

class SalesOrderLineRepository extends BaseRepository implements SalesOrderLineInterface
{

    public function __construct(SalesOrderLine $model)
    {
        parent::__construct($model);
    }
}
