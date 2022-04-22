<?php

namespace App\Http\Controllers;

use App\Models\{Gudang, Barang};
use Illuminate\Http\Request;
use App\Http\Requests\GudangRequest;

class GudangController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:gudang', [
            'only' => ['index','store', 'info', 'update', 'destroy']
        ]);
    }

    public function index(Gudang $gudang)
    {
    	$data = $gudang->all();
    	return view('admin.gudang.index', compact('data'));
    }

    public function store(Gudang $gudang, GudangRequest $request)
    {
    	$gudang->create($request->all());


    	return back()->with('success', 'Gudang berhasil ditambahkan');
    }

    public function info(Gudang $gudang)
    {
    	return $gudang->find(request('id'));
    }

    public function update(Gudang $gudang, GudangRequest $request)
    {
    	$gudang->find($request->id)->update($request->all());

    	return back();
    }

    public function destroy(Gudang $gudang, $id)
    {
    	$data = $gudang->find($id);
        Barang::where('gudang_id', $data->id)->delete();
        $data->delete();

    	return back();
    }
}
