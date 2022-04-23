<?php

namespace App\Http\Controllers;

use App\Models\{Supplier, Barang, BarangMasuk, Laporan};
use Illuminate\Http\Request;
use App\Http\Requests\BarangMasukRequest;

class BarangMasukController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:barang', [
            'only' => ['index','store', 'info', 'update', 'destroy']
        ]);
    }
    
    public function index(BarangMasuk $barang_masuk)
    {
    	$supplier = Supplier::select('nama', 'id')->get();
    	$barang = Barang::select('nama', 'id')->latest()->get();
		$data = $barang_masuk->with('supplier', 'barang')->get();

    	return view('admin.barang-masuk.index', compact('data', 'supplier', 'barang'));
    }

    public function store(BarangMasuk $barang_masuk, BarangMasukRequest $request)
    {
    	$result = $barang_masuk->create($request->all());
    	Barang::find($request->barang_id)->increment('jumlah', $request->jumlah);

    	// untuk laporan
    	Laporan::create([
    		'nama' => $result->barang->nama,
    		'orang' => $result->supplier->nama,
    		'jumlah' => $request->jumlah,
    		'berat' => $request->berat,
    		'harga' => $request->harga,
    		'jenis' => 'Barang Masuk',
    		'root_id' => $result->id
    	]);

    	return back()->with('success', 'Stok berhasil ditambahkan');
    }

    public function info(BarangMasuk $barang_masuk)
    {
    	$data = $barang_masuk->with('supplier', 'barang')->find(request('id'));

    	
    	return $data;
    }

    public function update(BarangMasuk $barang_masuk, BarangMasukRequest $request)
    {
    	$result = $barang_masuk->find($request->id);

    	$jumlah = $request->jumlah - $result->jumlah;

    	$result->update($request->all());

    	// untuk laporan
    	Laporan::where('jenis', 'Barang Masuk')->where('root_id', $result->id)->update([
    		'nama' => $result->barang->nama,
    		'orang' => $result->supplier->nama,
    		'jumlah' => $request->jumlah,
    		'berat' => $request->berat,
    		'harga' => $request->harga,
    		'jenis' => 'Barang Masuk'
    	]);

    	// untuk barang
    	$result->barang->increment('jumlah', $jumlah);

    	return back()->with('success', 'Stok berhasil di update');
    }

    public function destroy(BarangMasuk $barang_masuk, $id)
    {
    	$data = $barang_masuk->find($id);
        $data->barang->decrement('jumlah', $data->jumlah);
    	Laporan::where('jenis', 'Barang Masuk')->where('root_id', $data->id)->delete();
    	$data->delete();

    	return back();
    }
}
