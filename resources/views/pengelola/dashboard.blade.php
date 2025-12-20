<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengelola - HarmonyKids</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- STYLE SAMA SEPERTI SEBELUMNYA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f9fafb; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #ffffff; border-right: 1px solid #e5e7eb; position: fixed; height: 100%; padding: 24px; display: flex; flex-direction: column; }
        .brand { font-size: 20px; font-weight: 600; color: #4361ee; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #4b5563; text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s; font-size: 14px; }
        .nav-link:hover { background-color: #f3f4f6; color: #4361ee; }
        .nav-link.active { background-color: #eff6ff; color: #4361ee; font-weight: 500; }
        .logout-btn { margin-top: auto; border: none; background: none; cursor: pointer; color: #ef4444; width: 100%; text-align: left; }
        .main-content { margin-left: 250px; padding: 32px; width: 100%; }
        
        /* Form Styles */
        .card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 30px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); max-width: 900px; }
        .card-header { border-bottom: 1px solid #f3f4f6; padding-bottom: 15px; margin-bottom: 25px; }
        .card-title { font-size: 18px; font-weight: 600; color: #111827; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: span 2; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #374151; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #f9fafb; transition: 0.3s; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #4361ee; background: white; box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1); }
        .section-label { font-size: 14px; font-weight: 600; color: #4361ee; margin: 25px 0 15px 0; border-bottom: 2px solid #eef2ff; display: inline-block; padding-bottom: 5px; }
        .btn-primary { background-color: #4361ee; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; width: 100%; justify-content: center; }
        .btn-primary:hover { background-color: #3f37c9; }
        .img-preview { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fas fa-shapes"></i> HarmonyKids</div>
        <div class="menu-label">Pengelola</div>
        <a href="{{ route('pengelola.dashboard') }}" class="nav-link active"><i class="fas fa-school"></i> Sekolah Saya</a>
        <a href="{{ route('pengelola.pendaftaran') }}" class="nav-link"><i class="fas fa-file-signature"></i> Data Pendaftaran</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf <button type="submit" class="nav-link logout-btn"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>

    <div class="main-content">
        <h1 class="header-title">Profil Sekolah</h1>

        @if(session('success'))
            <div style="background:#ecfdf5; color:#065f46; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #a7f3d0;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(!$instansi)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Lengkapi Data Sekolah</h2>
                </div>
                
                <form action="{{ route('pengelola.instansi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="section-label">1. Foto & Informasi Dasar</div>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Foto Utama Sekolah (Thumbnail) <span style="color:red">*</span></label>
                            <input type="file" name="thumbnail" accept="image/*" required style="background: white;">
                            <small style="color:#6b7280;">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>

                        <div class="form-group">
                            <label>Nama Sekolah / Daycare</label>
                            <input type="text" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Instansi</label>
                            <select name="jenis_instansi" required>
                                <option value="" disabled selected>Pilih Jenis...</option>
                                <option value="TK/PG">TK/PG</option>
                                <option value="Daycare">Daycare</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kota / Kabupaten</label>
                            <input type="text" name="kota" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Operasional</label>
                            <input type="text" name="jam_operasional" placeholder="07.00 - 15.00">
                        </div>
                        <div class="form-group full-width">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" required></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label>Deskripsi Sekolah</label>
                            <textarea name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="section-label">2. Kontak & Detail</div>
                    <div class="form-grid">
                        <div class="form-group"><label>Email</label><input type="email" name="email"></div>
                        <div class="form-group"><label>No. Telepon</label><input type="text" name="nomor_telepon"></div>
                        <div class="form-group"><label>Program Belajar</label><input type="text" name="program_belajar"></div>
                        <div class="form-group"><label>Kategori Minat</label><input type="text" name="kategori_minat"></div>
                    </div>

                    <div class="section-label">3. Biaya</div>
                    <div class="form-grid">
                        <div class="form-group"><label>Biaya Pendaftaran (Rp)</label><input type="number" name="biaya_pendaftaran"></div>
                        <div class="form-group"><label>SPP Bulanan (Rp)</label><input type="number" name="biaya_angka"></div>
                        <div class="form-group full-width"><label>Tampilan Biaya (Teks)</label><input type="text" name="biaya_display" placeholder="Contoh: Rp 500rb / Bulan"></div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:20px;">
                        <i class="fas fa-paper-plane"></i> Simpan & Ajukan
                    </button>
                </form>
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Edit Data Sekolah</h2>
                </div>

                <form action="{{ route('pengelola.instansi.update', $instansi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="form-grid">
                         <div class="form-group full-width">
                            <label>Foto Utama Sekolah</label>
                            @if($instansi->thumbnail && $instansi->thumbnail != 'default.jpg')
                                <img src="{{ asset('uploads/instansi/' . $instansi->thumbnail) }}" class="img-preview">
                            @endif
                            <input type="file" name="thumbnail" accept="image/*" style="margin-top:10px;">
                            <small>Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>

                        <div class="form-group"><label>Nama Sekolah</label><input type="text" name="nama" value="{{ $instansi->nama }}"></div>
                        <div class="form-group"><label>Kota</label><input type="text" name="kota" value="{{ $instansi->kota }}"></div>
                        <div class="form-group full-width"><label>Alamat</label><textarea name="alamat">{{ $instansi->alamat }}</textarea></div>
                    </div>
                    
                    <button type="submit" class="btn-primary" style="margin-top:20px;">Update Data</button>
                </form>
            </div>
        @endif
    </div>
</body>
</html>