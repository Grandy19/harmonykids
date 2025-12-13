<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    // 1. GET ALL & SEARCH (Pencarian + Filter Minat)
    public function index(Request $request)
    {
        $query = Instansi::query();

        if ($request->filled('lokasi')) {
            $query->where('kota', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('jenis_instansi')) {
            $query->where('jenis_instansi', $request->jenis_instansi);
        }

        if ($request->filled('minat')) {
            $query->whereJsonContains('kategori_minat', $request->minat);
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Instansi',
            'data'    => $query->get()
        ]);
    }

    // 2. BANDINGKAN INSTANSI (Terima array ID)
    public function compare(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:2'
        ]);

        $data = Instansi::whereIn('id', $request->ids)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Perbandingan',
            'data'    => $data
        ]);
    }

    // 3. DETAIL INSTANSI
    public function show($id)
    {
        $instansi = Instansi::find($id);

        if (!$instansi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $instansi
        ]);
    }

    // 4. INPUT DATA BARU
    public function store(Request $request)
    {
        // Validasi sederhana
        $data = $request->all();
        
        // Simpan ke DB
        $instansi = Instansi::create($data);
        
        return response()->json([
            'success' => true, 
            'message' => 'Data Berhasil Disimpan',
            'data' => $instansi
        ]);
    }
}