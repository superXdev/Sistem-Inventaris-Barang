<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:barang', [
            'only' => ['index','store', 'info', 'update', 'destroy']
        ]);
    }
    
    public function index(Supplier $supplier)
    {
		$data = $supplier->all();

    	return view('admin.supplier.index', compact('data'));
    }

    public function store(Supplier $supplier, SupplierRequest $request)
    {
    	$supplier->create($request->all());

    	return back()->with('success', 'Supplier berhasil ditambahkan');
    }

    public function info(Supplier $supplier)
    {
    	$data = $supplier->find(request('id'));

    	return $data;
    }

    public function update(Supplier $supplier, SupplierRequest $request)
    {
    	$supplier->find($request->id)->update($request->all());

    	return back()->with('success', 'Supplier berhasil di update');
    }

    public function destroy(Supplier $supplier, $id)
    {
    	$data = $supplier->find($id);
    	$data->delete();

    	return back();
    }
}
