<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->tokenCan('invoice:createBulk');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.customerId' => 'required|integer|exists:customers,id',
            '*.amount' => 'required|numeric',
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])], 
            '*.billedDate' => 'required|date_format:Y-m-d H:i:s',
            '*.paidDate' => 'nullable|date_format:Y-m-d H:i:s',
        ];
        
    }

    protected function passedValidation()
    {
        $data = [];

        foreach($this->toArray() as $obj) {
            $obj['customer_id'] = $obj['customerId'];
            $obj['billed_date'] = $obj['billedDate'];
            $obj['paid_date'] = $obj['paidDate'] ?? null;
            $obj['user_id'] = $this->user()->id;
            unset($obj['customerId']);
            unset($obj['billedDate']);
            unset($obj['paidDate']);
            $data[] = $obj;
        }

        $this->merge($data);
    }
}
