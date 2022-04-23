<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
            'kode' => 'required|string|unique:barangs',
            'nama' => 'required|string',
            'jumlah' => 'required|numeric|gt:0',
            'kondisi' => 'required|numeric|gte:0|lt:2',
            'gudang_id' => 'required|numeric'
        ];
    }
}
