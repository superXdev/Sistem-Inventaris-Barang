<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Laporan $laporan)
    {
    	$data = $laporan->latest()->get();
    	return view('admin.laporan.index', compact('data'));
    }
}
