<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    // 1. DAFTAR SEKOLAH (Wali Upload Data & Bukti Bayar)
    public function store(Request $request)
    {
        // Validasi Input Sesuai Form
        $validator = Validator::make($request->all(), [
            'instansi_id'       => 'required|exists:instansi,id',
            'nama_anak'         => 'required|string',
            'tempat_lahir'      => 'required|string',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|string',
            'agama'             => 'required|string',
            'alamat'            => 'required|string',
            'kewarganegaraan'   => 'required|string',
            'bukti_bayar'       => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib Gambar
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Proses Upload Gambar Bukti Bayar
        $imagePath = null;
        if ($request->hasFile('bukti_bayar')) {
            // Simpan di folder public/uploads/pendaftaran
            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pendaftaran'), $filename);
            $imagePath = 'uploads/pendaftaran/' . $filename;
        }

        // Simpan ke Database
        $pendaftaran = Pendaftaran::create([
            'user_id'           => $request->user()->id, 
            'instansi_id'       => $request->instansi_id,
            'nama_anak'         => $request->nama_anak,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'agama'             => $request->agama,
            'alamat'            => $request->alamat,
            'riwayat_kesehatan' => $request->riwayat_kesehatan,
            'kewarganegaraan'   => $request->kewarganegaraan,
            'bukti_bayar'       => $imagePath,
            'status_pendaftaran'=> 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran Berhasil dikirim! Tunggu konfirmasi sekolah.',
            'data' => $pendaftaran
        ], 201);
    }

    // 2. LIHAT STATUS PENDAFTARAN 
    public function myRegistrations(Request $request)
    {
        $data = Pendaftaran::with('instansi') // Sertakan data sekolahnya
                    ->where('user_id', $request->user()->id)
                    ->latest()
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}