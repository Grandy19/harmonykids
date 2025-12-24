<?php

namespace App\Http\Controllers\Api\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instansi;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Parameter (Samakan dengan key di Flutter)
        $kota = $request->query('kota');
        // Gunakan 'jenis_instansi' sesuai dengan URL yang dikirim Flutter
        $jenis = $request->query('jenis_instansi'); 

        // 2. Jika Lokasi belum dipilih, return list kosong
        if (!$kota) {
            return response()->json([
                'status' => 'success',
                'message' => 'Silakan pilih lokasi terlebih dahulu.',
                'data' => [] 
            ], 200);
        }

        // 3. Mulai Query
        $query = Instansi::query();

        // Filter Kota
        $query->where('kota', $kota);

        // Filter Jenis Instansi
        if ($jenis) {
            $query->where('jenis_instansi', $jenis);
        }

        // Ambil Data
        $instansi = $query->with('user')->get();

        // Append thumbnail_url (Hanya jalan jika Accessor di Model sudah dibuat)
        $instansi->each->append('thumbnail_url');

        return response()->json([
            'status' => 'success',
            'data' => $instansi
        ], 200);
    }
}