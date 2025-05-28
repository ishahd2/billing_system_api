<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->tokenCan('invoice:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == "PUT") {
            return [
                'customerId' => 'required|integer|exists:customers,id',
                'amount' => 'required|numeric',
                'status' => 'required|in:B,P,V,b,p,v',
                'billedDate' => 'required|date_format:Y-m-d H:i:s',
                'paidDate' => 'nullable|date_format:Y-m-d H:i:s',
            ];
        }
        return [
            'customerId' => 'sometimes|required|integer|exists:customers,id',
            'amount' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:B,P,V,b,p,v',
            'billedDate' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'paidDate' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId,
            'billed_date' => $this->billedDate,
            'paid_date' => $this->paidDate ?? null,
        ]);
    }
}
