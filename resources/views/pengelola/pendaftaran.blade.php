<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pendaftaran - HarmonyKids</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- GLOBAL STYLE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f9fafb; color: #333; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 250px; background: #ffffff; border-right: 1px solid #e5e7eb; position: fixed; height: 100%; padding: 24px; display: flex; flex-direction: column; }
        .brand { font-size: 20px; font-weight: 600; color: #4361ee; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .menu-label { font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; font-weight: 500; }
        
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #4b5563; text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s; font-size: 14px; }
        .nav-link:hover { background-color: #f3f4f6; color: #4361ee; }
        .nav-link.active { background-color: #eff6ff; color: #4361ee; font-weight: 500; }

        .logout-btn { margin-top: auto; border: none; background: none; cursor: pointer; color: #ef4444; width: 100%; text-align: left; }
        .logout-btn:hover { background-color: #fef2f2; }

        /* Main Content */
        .main-content { margin-left: 250px; padding: 32px; width: 100%; }
        .header-title { font-size: 24px; font-weight: 600; margin-bottom: 5px; color: #111827; }
        .header-subtitle { color: #6b7280; font-size: 14px; margin-bottom: 24px; }

        /* Table Card */
        .table-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        th { text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; }
        td { padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #fafafa; }

        /* Badges */
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px; }
        .bg-pending { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
        .bg-accepted { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .bg-rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Buttons */
        .btn-action { padding: 8px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 5px; transition: 0.2s; }
        .btn-accept { background: #ecfdf5; color: #059669; }
        .btn-accept:hover { background: #10b981; color: white; }
        .btn-reject { background: #fef2f2; color: #dc2626; }
        .btn-reject:hover { background: #ef4444; color: white; }

        /* Child Info Helper */
        .info-row { display: flex; gap: 5px; align-items: center; font-size: 13px; color: #6b7280; margin-top: 2px; }
        .info-row i { font-size: 12px; width: 15px; }

        /* Alert */
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fas fa-shapes"></i> HarmonyKids</div>
        <div class="menu-label">Pengelola</div>
        
        <a href="{{ route('pengelola.dashboard') }}" class="nav-link">
            <i class="fas fa-school"></i> Sekolah Saya
        </a>
        <a href="{{ route('pengelola.pendaftaran') }}" class="nav-link active">
            <i class="fas fa-file-signature"></i> Data Pendaftaran
        </a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="nav-link logout-btn"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>

    <div class="main-content">
        <h1 class="header-title">Data Pendaftaran Masuk</h1>
        <p class="header-subtitle">Daftar siswa baru yang mendaftar ke sekolah Anda.</p>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Data Calon Siswa</th>
                        <th width="20%">Wali Murid</th>
                        <th width="15%">Pembayaran</th>
                        <th width="15%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $item)
                    <tr>
                        <td style="text-align:center; color:#9ca3af;">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight:600; color:#1f2937; font-size:15px;">{{ $item->nama_anak }}</div>
                            
                            <div class="info-row">
                                <i class="fas fa-birthday-cake"></i> 
                                {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}
                            </div>
                            <div class="info-row">
                                <i class="fas fa-venus-mars"></i> 
                                {{ $item->jenis_kelamin }}
                            </div>
                            <div class="info-row">
                                <i class="fas fa-heartbeat"></i> 
                                {{ Str::limit($item->riwayat_kesehatan ?? 'Sehat', 20) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500;">{{ $item->user->name ?? 'User Hilang' }}</div>
                            <small style="color:#9ca3af;">{{ $item->user->email ?? '-' }}</small>
                        </td>
                        <td>
                            @if($item->bukti_bayar)
                                <a href="#" style="color:#4361ee; font-size:12px; font-weight:500; text-decoration:none;">
                                    <i class="fas fa-image"></i> Lihat Bukti
                                </a>
                            @else
                                <span style="color:#9ca3af; font-size:12px;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status_pendaftaran == 'pending')
                                <span class="badge bg-pending"><i class="fas fa-clock"></i> Menunggu</span>
                            @elseif($item->status_pendaftaran == 'accepted')
                                <span class="badge bg-accepted"><i class="fas fa-check"></i> Diterima</span>
                            @else
                                <span class="badge bg-rejected"><i class="fas fa-times"></i> Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status_pendaftaran == 'pending')
                                <div style="display:flex; gap:5px;">
                                    <form action="{{ route('pengelola.pendaftaran.approve', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn-action btn-accept" title="Terima Siswa"><i class="fas fa-check"></i></button>
                                    </form>
                                    <form action="{{ route('pengelola.pendaftaran.reject', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn-action btn-reject" title="Tolak Siswa"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            @else
                                <span style="font-size:12px; color:#9ca3af;"><i class="fas fa-lock"></i> Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:50px; color:#9ca3af;">
                            <i class="fas fa-inbox" style="font-size:32px; margin-bottom:10px; display:block; opacity:0.5;"></i>
                            Belum ada pendaftaran masuk saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>