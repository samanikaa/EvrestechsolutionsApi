<?php

namespace App\Repositories\Implementations;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerRepository extends BaseRepository implements CustomerInterface
{
    
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
    
    public function create($data)
    {
        try {
            $data['id'] = $data['id'] ?? (string) Str::uuid();
            $data['password'] = Hash::make($data['password']);
            $record=$this->model->create($data);
            return ['status'=>'success', 'message'=>'Record created successfully', 'data'=>$record];
        } catch (\Exception $e) {
            return ['status'=>'error', 'message'=>$e->getMessage(), 'data'=>[]];
        }
    }
}
