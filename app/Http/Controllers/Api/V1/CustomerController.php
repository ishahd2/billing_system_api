<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->tokenCan('customer:read')) {
            return $this->errorResponse('Unauthorized action.', 403);
        }
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request);

        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);

        if ($includeInvoices) {
            $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return $this->successResponse('Customer created successfully', new CustomerResource($customer), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $user = request()->user();
        if (!$user->tokenCan('customer:read')) {
            return $this->errorResponse('Unauthorized action.', 403);
        }
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {
            $customer->loadMissing('invoices');
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return $this->successResponse('Customer updated successfully', new CustomerResource($customer));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $user = request()->user();
        if (!$user->tokenCan('customer:delete') ) {
            return $this->errorResponse('Unauthorized action.', 403);
         }

        $customer->delete();

        return response()->noContent();
    }
}
