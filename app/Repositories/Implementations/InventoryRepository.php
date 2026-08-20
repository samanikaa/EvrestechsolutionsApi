<?php

namespace App\Repositories\Implementations;

use App\Models\Inventory;
use App\Repositories\Contracts\InventoryInterface;

class InventoryRepository extends BaseRepository implements InventoryInterface
{

    public function __construct(Inventory $model)
    {
        parent::__construct($model);
    }
}
