<?php

namespace App\Repositories\Implementations;

use App\Models\Warehouse;
use App\Repositories\Contracts\WarehouseInterface;

class WarehouseRepository extends BaseRepository implements WarehouseInterface
{

    public function __construct(Warehouse $model)
    {
        parent::__construct($model);
    }
}
