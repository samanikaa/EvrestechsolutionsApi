<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Repositories\Contracts\CustomerInterface;

class CustomerController extends Controller
{
    protected $customerRepo;
    public function __construct(CustomerInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result=$this->customerRepo->getPaginated();
        if(!$result)
        {
            return response()->json([
                'status'=>'error',
                'message'=>'Customers not found',
                'data'=>[]
            ],404);
        }
        return CustomerResource::collection($result)
        ->additional([
            'status'=>'success', 
            'message'=>'Customer list retrieved successfully'
        ])->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $result = $this->customerRepo->create($request->validated());
        if($result['status'] !== 'success') {
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>$result['data']
            ], 422);
        }
        return new CustomerResource($result['data'])
        ->additional([
            'status'=>$result['status'], 
            'message'=>$result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $customerId)
    {
        $result=$this->customerRepo->existsById($customerId);
        
        if(!$result) {
            return response()->json([
                'status'=>'error',
                'message'=>'Customer not found',
                'data'=>[]
            ], 404);
        }
        return new CustomerResource($result)
        ->additional([
            'status'=>'success',
            'message'=>'Customer details retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $customerId)
    {
        $result = $this->customerRepo->update($customerId, $request->validated());
        if($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>$result['data']
            ], $code);
        }
        return new CustomerResource($result['data'])
        ->additional([
            'status'=>$result['status'], 
            'message'=>$result['message']
        ])->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $customerId)
    {
        $result = $this->customerRepo->delete($customerId);
        if($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>$result['data']
            ], $code);
        }
        return new CustomerResource($result['data'])
        ->additional([
            'status'=>$result['status'], 
            'message'=>$result['message']
        ])->response();
    }
}
