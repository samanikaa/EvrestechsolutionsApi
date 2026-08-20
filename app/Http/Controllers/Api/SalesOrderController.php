<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreSalesOrderRequest;
use App\Http\Requests\V1\UpdateSalesOrderRequest;
use App\Http\Resources\V1\SalesOrderResource;
use App\Repositories\Contracts\SalesOrderInterface;

class SalesOrderController extends Controller
{
    protected $salesOrderRepo;
    public function __construct(SalesOrderInterface $salesOrderRepo)
    {
        $this->salesOrderRepo = $salesOrderRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->salesOrderRepo->getPaginated();
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales orders not found',
                'data' => []
            ], 404);
        }
        return SalesOrderResource::collection($result)
        ->additional([
            'status' => 'success',
            'message' => 'Sales order list retrieved successfully'
        ])->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesOrderRequest $request)
    {
        $result = $this->salesOrderRepo->create($request->validated());
        if ($result['status'] !== 'success') {
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], 422);
        }
        return new SalesOrderResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $salesOrderId)
    {
        $result = $this->salesOrderRepo->existsById($salesOrderId);
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order not found',
                'data' => []
            ], 404);
        }
        return new SalesOrderResource($result)
        ->additional([
            'status' => 'success',
            'message' => 'Sales order retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderRequest $request, string $salesOrderId)
    {
        $result = $this->salesOrderRepo->update($salesOrderId, $request->validated());
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new SalesOrderResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $salesOrderId)
    {
        $result = $this->salesOrderRepo->delete($salesOrderId);
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new SalesOrderResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }
}
