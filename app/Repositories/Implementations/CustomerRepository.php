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
        }  catch (\Exception $e) {
            if($e->getCode() == 23505) {
                return ['status'=>'error', 'message'=>'Duplicate entry', 'data'=>[]];
            }
            Log::error('Error creating record: ',[
                'model' => get_class($this->model),
                'message' => $e->getMessage()
            ]);
            return ['status'=>'error', 'message'=>'Something went wrong. Please try again.', 'data'=>[]];
        }
    }
}
