<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangMasukRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required|numeric|gt:0', 
            'berat' => 'required|numeric|gt:0', 
            'barang_id' => 'required|numeric|gt:0', 
            'harga' => 'required|string',
            'jumlah' => 'required|numeric|gt:0'
        ];
    }
}
