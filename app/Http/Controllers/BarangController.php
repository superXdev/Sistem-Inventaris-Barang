<?php

namespace App\Http\Controllers;

use App\Models\{Barang, Gudang};
use Illuminate\Http\Request;
use App\Http\Requests\BarangRequest;

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

    public function store(Barang $barang, Gudang $gudang, BarangRequest $request)
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

    public function update(Barang $barang, BarangRequest $request)
    {
    	$barang->find($request->id)->update($request->all());

    	return back();
    }

    public function destroy(Barang $barang, $id)
    {
    	$data = $barang->find($id);
    	$data->delete();

    	return back();
    }
}
