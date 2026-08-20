<?php

namespace App\Repositories\Implementations;

use App\Models\Product;
use App\Repositories\Contracts\ProductInterface;

class ProductRepository extends BaseRepository implements ProductInterface
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
