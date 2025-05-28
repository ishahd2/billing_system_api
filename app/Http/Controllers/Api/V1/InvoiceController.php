<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Http\Requests\V1\StoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->tokenCan('invoice:read')) {
            return $this->errorResponse('Unauthorized action.', 403);
        }
        // Apply filters to the query
        // If the user is a regular user, filter by user_id
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request);

        if($user->isUser()){
            $queryItems[] = ['user_id', '=', $user->id];
        } 

        $invoices = Invoice::where($queryItems)->paginate();

        return new InvoiceCollection($invoices->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());

        return $this->successResponse('Invoice created successfully', new InvoiceResource($invoice), 201);
    }

    /**
     * Store multiple resources in storage.
     */
    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        Invoice::insert($request->all());

        return $this->successResponse('Invoices created successfully', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $user = request()->user();
        if (!$user->tokenCan('invoice:read') || ($user->isUser() && $invoice->user_id !== $user->id)) {
           return $this->errorResponse('Unauthorized action.', 403);
        }
    
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return $this->successResponse('Invoice updated successfully', new InvoiceResource($invoice));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $user = request()->user();
        if (!$user->tokenCan('invoice:delete') ) {
            return $this->errorResponse('Unauthorized action.', 403);
         }

        $invoice->delete();

        return response()->noContent();
    }
}
