<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreWarehouseRequest;
use App\Http\Requests\V1\UpdateWarehouseRequest;
use App\Http\Resources\V1\WarehouseResource;
use App\Repositories\Contracts\WarehouseInterface;

class WarehouseController extends Controller
{
    protected $warehouseRepo;
    public function __construct(WarehouseInterface $warehouseRepo)
    {
        $this->warehouseRepo = $warehouseRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->warehouseRepo->getPaginated();
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Warehouses not found',
                'data' => []
            ], 404);
        }
        return WarehouseResource::collection($result)
        ->additional([
            'status' => 'success',
            'message' => 'Warehouse list retrieved successfully'
        ])->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $result = $this->warehouseRepo->create($request->validated());
        if ($result['status'] !== 'success') {
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], 422);
        }
        return new WarehouseResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $warehouseId)
    {
        $result = $this->warehouseRepo->existsById($warehouseId);
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Warehouse not found',
                'data' => []
            ], 404);
        }
        return new WarehouseResource($result)
        ->additional([
            'status' => 'success',
            'message' => 'Warehouse retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $warehouseId)
    {
        $result = $this->warehouseRepo->update($warehouseId, $request->validated());
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new WarehouseResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $warehouseId)
    {
        $result = $this->warehouseRepo->delete($warehouseId);
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new WarehouseResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }
}
