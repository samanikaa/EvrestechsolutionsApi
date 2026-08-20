<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Repositories\Contracts\ProductInterface;

class ProductController extends Controller
{
    protected $productRepo;
    public function __construct(ProductInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->productRepo->getPaginated();
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Products not found',
                'data' => []
            ], 404);
        }
        return ProductResource::collection($result)
        ->additional([
            'status' => 'success',
            'message' => 'Product list retrieved successfully'
        ])->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $result = $this->productRepo->create($request->validated());
        if ($result['status'] !== 'success') {
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], 422);
        }
        return new ProductResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productId)
    {
        $result = $this->productRepo->existsById($productId);
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }
        return new ProductResource($result)
        ->additional([
            'status' => 'success',
            'message' => 'Product retrieved successfully'
        ])->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $productId)
    {
        $result = $this->productRepo->update($productId, $request->validated());
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new ProductResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId)
    {
        $result = $this->productRepo->delete($productId);
        if ($result['status'] !== 'success') {
            $code = $result['message'] === 'Record not found' ? 404 : 422;
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'data' => $result['data']
            ], $code);
        }
        return new ProductResource($result['data'])
        ->additional([
            'status' => $result['status'],
            'message' => $result['message']
        ])->response();
    }
}
