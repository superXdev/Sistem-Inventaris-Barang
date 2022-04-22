<?php

namespace App\Http\Controllers;

use App\Models\{Barang, Gudang};
use Illuminate\Http\Request;

class BarangController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:barang', [
            'only' => ['index','store', 'info', 'update', 'destroy']
        ]);
    }
    
    public function index(Barang $barang)
    {
    	$gudang = Gudang::all();

    	$data = null;

    	if(request('filter_gudang')) {
    		$data = $barang->where('gudang_id', request('filter_gudang'))->get();
    	} else {

	    	$data = $barang->all();
	    }

    	return view('admin.barang.index', compact('data', 'gudang'));
    }

    public function store(Barang $barang, Gudang $gudang, Request $request)
    {
    	$barang->create($request->all());

    	return back()->with('success', 'barang berhasil ditambahkan');
    }

    public function info(Barang $barang)
    {
    	$data = $barang->find(request('id'));
        $gudang = Gudang::find($data->gudang_id);
    	return [
    		'barang' => $data,
    		'gudang' => [
                'id' => $gudang->id,
                'nama' => $gudang->nama
            ]
    	];
    }

    public function update(Barang $barang, Request $request)
    {
    	$barang->find($request->id)->update($request->all());

    	return back();
    }

    public function destroy(Barang $barang, Request $request)
    {
    	$data = $barang->find($request->id);
    	$data->delete();

    	return back();
    }
}
