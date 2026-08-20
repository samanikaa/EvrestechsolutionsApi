<?php

namespace App\Repositories\Contracts;

interface BaseInterface
{
    public function create($data);
    public function getPaginated($itemsPerPage= 10);
    public function getAll();
    public function getById($id);
    public function existsById($id);
    public function update($id, $data);
    public function delete($id);
}
