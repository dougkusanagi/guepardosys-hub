<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => '',
            'name' => 'required|unique:products',
            'slug' => 'required|unique:products',
            'model' => 'nullable|unique:products',
            'price' => 'required',
            'description' => 'nullable',
            'description_html' => 'nullable',
            'stock_local' => 'nullable',
            'stock_local_min' => 'nullable',
            'stock_virtual' => 'nullable',
            'barcode' => 'nullable',
            'ncm' => 'nullable',
            'weight' => 'nullable',
            'height' => 'nullable',
            'width' => 'nullable',
            'length' => 'nullable',
            'availability' => 'nullable',
            'keywords' => 'nullable',
            'status' => 'nullable',
            'brand' => 'nullable',
        ];
    }
}
