<?php

namespace App\Repositories\Implementations;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
