<?php

namespace App\Repositories\Implementations;

use App\Repositories\Contracts\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        try {
            $data['id'] = $data['id'] ?? (string) Str::uuid();
            $record=$this->model->create($data);
            return ['status'=>'success', 'message'=>'Record created successfully', 'data'=>$record];
        } catch (\Exception $e) {
            return ['status'=>'error', 'message'=>$e->getMessage(), 'data'=>[]];
        }
    }
    public function getPaginated($itemsPerPage= 10)
    {
        return $this->model->paginate($itemsPerPage);
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->find($id);
    }
    public function existsById($id)
    {
        return $this->model->where('id', $id)->first();
    }
    public function update($id, $data)
    {
        try {
            $record = $this->existsById($id);
            if(!$record) {
                return ['status'=>'error', 'message'=>'Record not found', 'data'=>[]];
            }
            $record->update($data);
            return ['status'=>'success', 'message'=>'Record updated successfully', 'data'=>$record];
        } catch (\Exception $e) {
            return ['status'=>'error', 'message'=>$e->getMessage(), 'data'=>[]];
        }
    }
    public function delete($id)
    {
        try {
            $record = $this->existsById($id);
            if(!$record) {
                return ['status'=>'error', 'message'=>'Record not found'];
            }
            $record->delete();
            return ['status'=>'success', 'message'=>'Record deleted successfully', 'data'=>$record];
        } catch (\Exception $e) {
            return ['status'=>'error', 'message'=>$e->getMessage(), 'data'=>[]];
        }
    }
}
