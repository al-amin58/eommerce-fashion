<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\V1\CustomerCollection;
use App\Http\Resources\Resource\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollection
     */
    public function index(): CustomerCollection
    {
        return new CustomerCollection(Customer::with('user')->simplePaginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Customer
     */
    public function destroy(Customer $customer): Customer
    {
        return $customer;
    }
}
