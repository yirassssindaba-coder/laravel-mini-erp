<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class InventoryMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->type === 'out') {
                $product = Product::find($this->product_id);
                if ($product && $product->stock < $this->quantity) {
                    $validator->errors()->add('quantity', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'type.required' => 'Tipe pergerakan wajib dipilih.',
            'type.in' => 'Tipe pergerakan tidak valid.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal 1.',
        ];
    }
}
