<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'customerid'=>$this->id,
            'customertype'=>$this->type,
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'billing_address'=>$this->billingaddress,
            'shipping_address'=>$this->shippingaddress,
            'acc_creation_date'=>$this->created_at,
        ];
    }
}
