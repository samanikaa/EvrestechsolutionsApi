<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreSalesOrderLineRequest;
use App\Http\Requests\V1\UpdateSalesOrderLineRequest;
use App\Http\Resources\V1\SalesOrderLineResource;
use App\Repositories\Contracts\SalesOrderLineInterface;

class SalesOrderLineController extends Controller
{
    protected $salesOrderLineRepo;
    public function __construct(SalesOrderLineInterface $salesOrderLineRepo)
    {
        $this->salesOrderLineRepo = $salesOrderLineRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->salesOrderLineRepo->getPaginated();
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order lines not found',
                'data' => []
            ], 404);
        }
        return SalesOrderLineResource::collection($result)
        ->additional([
            'status' => 'success',
            'message' => 'Sales order line list retrieved successfully'
        ])->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesOrderLineRequest $request)
    {
        $result = $this->salesOrderLineRepo->create($request->validated());
        if ($result['status'] !== 'success') {
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], 422);
        }
        return new SalesOrderLineResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $salesOrderLineId)
    {
        $result = $this->salesOrderLineRepo->existsById($salesOrderLineId);
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order line not found',
                'data' => []
            ], 404);
        }
        return new SalesOrderLineResource($result)
        ->additional([
            'status' => 'success',
            'message' => 'Sales order line retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderLineRequest $request, string $salesOrderLineId)
    {
        $result = $this->salesOrderLineRepo->update($salesOrderLineId, $request->validated());
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new SalesOrderLineResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $salesOrderLineId)
    {
        $result = $this->salesOrderLineRepo->delete($salesOrderLineId);
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new SalesOrderLineResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }
}
