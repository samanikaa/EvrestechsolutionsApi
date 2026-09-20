<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginCustomerRequest;
use App\Http\Requests\V1\RegisterCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Repositories\Contracts\CustomerInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $customerRepo;

    public $customerusertype;
    public function __construct(CustomerInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
        $this->customerusertype='customer';
    }
    /**
     * Register new customer
     */
    public function register(RegisterCustomerRequest $request)
    { 
        $validatedUserDetails=$request->validated();
        $validatedUserDetails['type'] = $this->customerusertype;

        $result=$this->customerRepo->create($validatedUserDetails);
        if($result['status']!='success')
        {
            return response()->json([
                'status'=>$result['status'],
                'message'=>$result['message'],
                'data'=>$result['data']
            ],422);
        }
        $token=$result['data']->createToken('customer-api-token', ['*'], now()->addMinutes(5) )->plainTextToken;

        return new CustomerResource($result['data'])
        ->additional([
            'status'=>$result['status'],
            'message'=>$result['message'],
            'token'=>$token
        ])->response()->setStatusCode(201);

    }

    /**
     * Login registered customer
     */
    public function login(LoginCustomerRequest $request)
    {
        $credentials = $request->validated();
        
        if (!auth('customer')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials provided',
            ], 401);
        }

        /** @var User $user */
        $user = auth('customer')->user();
        $user->tokens()->where('tokenable_id',$user->id)->where('name','customer-api-token')->delete(); // Revoke all existing user's tokens
        $token = $user->createToken('customer-api-token', ['*'], now()->addMinutes(5))->plainTextToken;
      

        return new CustomerResource($user)->additional([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }
    /**
     * Get authenticatedcustomer profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        return new CustomerResource($user)->additional([
            'status' => 'success',
            'message' => 'Profile retrieved successfully',
        ]);
    }


    /**
     * Logout authenticated customer
     */
    public function logout(Request $request)
    {        
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

}
