<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangKeluarRequest extends FormRequest
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
            'penerima' => 'required|string', 
            'berat' => 'required|numeric|gt:0', 
            'barang_id' => 'required|numeric|gt:0', 
            'harga' => 'required|string', 
            'jumlah' => 'required|numeric|gt:0'
        ];
    }
}
