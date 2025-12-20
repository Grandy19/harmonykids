<?php

namespace App\Http\Controllers\Pengelola; // Pastikan file ada di folder app/Http/Controllers/Pengelola/

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Pendaftaran; 
use Illuminate\Support\Facades\Auth;

class PengelolaController extends Controller
{
    // --- DASHBOARD ---
    public function index()
    {
        $userId = Auth::id();
        $instansi = Instansi::where('user_id', $userId)->first();
        
        $totalPendaftar = 0;
        $menungguVerifikasi = 0;

        if($instansi) {
            $totalPendaftar = Pendaftaran::where('instansi_id', $instansi->id)->count();
            // Menghitung status pending
            $menungguVerifikasi = Pendaftaran::where('instansi_id', $instansi->id)
                                           ->where('status_pendaftaran', 'pending')
                                           ->count();
        }

        return view('pengelola.dashboard', compact('instansi', 'totalPendaftar', 'menungguVerifikasi'));
    }

    // --- SIMPAN DATA SEKOLAH (CREATE) ---
    public function storeInstansi(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama' => 'required',
            'jenis_instansi' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar (Max 2MB)
        ]);

        // 2. PROSES UPLOAD GAMBAR
        $thumbnailName = 'default.jpg'; // Nama default jika tidak ada gambar

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            // Bikin nama unik: time() + nama_asli.jpg
            $thumbnailName = time() . '_' . $file->getClientOriginalName();
            // Pindahkan file ke folder public/uploads/instansi
            $file->move(public_path('uploads/instansi'), $thumbnailName);
        }

        // 3. Simpan ke Database
        Instansi::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            
            // Masukkan nama file gambar ke database
            'thumbnail' => $thumbnailName, 
            
            // Data Input Lainnya
            'nama' => $request->nama,
            'jenis_instansi' => $request->jenis_instansi,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'jam_operasional' => $request->jam_operasional,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'program_belajar' => $request->program_belajar,
            'kategori_minat' => $request->kategori_minat,
            'biaya_pendaftaran' => $request->biaya_pendaftaran ?? 0,
            'biaya_angka' => $request->biaya_angka ?? 0,
            'biaya_display' => $request->biaya_display,
            
            // Default 0
            'rating' => 0, 'is_popular' => 0, 'skor_fasilitas' => 0,
            'skor_keamanan' => 0, 'skor_kenyamanan' => 0,
            'skor_pengajar' => 0, 'skor_layanan' => 0,
        ]);

        return back()->with('success', 'Data sekolah & foto berhasil disimpan!');
    }

    // --- UPDATE DATA SEKOLAH (EDIT) ---
    public function updateInstansi(Request $request, $id)
    {
        $instansi = Instansi::where('user_id', Auth::id())->findOrFail($id);
        
        // Ambil semua data input KECUALI thumbnail (karena perlu diproses manual)
        $data = $request->except(['thumbnail']);

        // Cek jika ada upload foto baru
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file baru
            $file->move(public_path('uploads/instansi'), $thumbnailName);
            
            // Masukkan nama file baru ke array data update
            $data['thumbnail'] = $thumbnailName;
        }

        $instansi->update($data);

        return back()->with('success', 'Data sekolah diperbarui.');
    }

    // --- MANAJEMEN PENDAFTARAN (PPDB) ---

    // 1. Halaman List Pendaftaran
    public function indexPendaftaran()
    {
        // Cek sekolah milik user login
        $instansi = \App\Models\Instansi::where('user_id', auth()->id())->first();

        // LOGIC BARU: Jangan ditendang (redirect), tapi berikan data kosong jika belum punya sekolah
        if(!$instansi) {
            $pendaftarans = collect(); 
        } else {
            // Jika sekolah ada, baru ambil datanya
            $pendaftarans = \App\Models\Pendaftaran::where('instansi_id', $instansi->id)
                            ->with('user') 
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return view('pengelola.pendaftaran', compact('pendaftarans'));
    }

    // 2. Terima (Approve)
    public function approvePendaftaran($id)
    {
        $data = \App\Models\Pendaftaran::findOrFail($id);
        
        $data->status_pendaftaran = 'accepted'; 
        $data->save();

        return back()->with('success', 'Siswa berhasil diterima! Status diperbarui.');
    }

    // 3. Tolak (Reject)
    public function rejectPendaftaran($id)
    {
        $data = \App\Models\Pendaftaran::findOrFail($id);
        
        $data->status_pendaftaran = 'rejected'; 
        $data->save();

        return back()->with('success', 'Pendaftaran ditolak.');
    }
}