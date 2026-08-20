<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInventoryRequest;
use App\Http\Requests\V1\UpdateInventoryRequest;
use App\Http\Resources\V1\InventoryResource;
use App\Repositories\Contracts\InventoryInterface;

class InventoryController extends Controller
{
    protected $inventoryRepo;
    public function __construct(InventoryInterface $inventoryRepo)
    {
        $this->inventoryRepo = $inventoryRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result=$this->inventoryRepo->getPaginated();
        if(!$result)
        {
            return response()->json([
                'status'=>'error',
                'message'=>'Inventory not found',
                'data'=>[]
            ],404);
        }
        return InventoryResource::collection($result)
        ->additional([
            'status'=>'success', 
            'message'=>'Inventory list retrieved successfully'
        ])
        ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        $result=$this->inventoryRepo->create($request->validated());

        if($result['status'] !== 'success') {
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>$result['data']
            ], 422);
        }

        return new InventoryResource($result['data'])
        ->additional([
            'status'=>$result['status'],
            'message'=>$result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $inventoryId)
    {
        $result=$this->inventoryRepo->existsById($inventoryId);
        if(!$result)
        {
            return response()->json([
                'status'=>'error',
                'message'=>'Inventory not found',
                'data'=>[]
            ]);
        }
        return new InventoryResource($result)
        ->additional([
            'status'=>'success',
            'message'=>'Inventory retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, string $inventoryId)
    {
        $result=$this->inventoryRepo->update($inventoryId, $request->validated());
        if($result['status']!=='success')
        {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>[]
            ],$code);
        }
        return new InventoryResource($result['data'])
        ->additional([
            'status'=>$result['status'],
            'message'=>$result['message'],
        ])
        ->response();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $inventoryId)
    {
        $result=$this->inventoryRepo->delete($inventoryId);
        if($result['status']!=='success')
        {
            $code=$result['message']==='Record not found'?404:422;
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>[]
            ],$code);
        }
        return new InventoryResource($result['data'])
        ->additional([
            'status'=>$result['status'],
            'message'=>$result['message']
        ])
        ->response();
    }
}
