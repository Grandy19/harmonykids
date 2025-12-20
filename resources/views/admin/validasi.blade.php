<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Instansi - HarmonyKids</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- COPY STYLE DARI DASHBOARD --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f9fafb; color: #333; display: flex; min-height: 100vh; }

        /* Sidebar Style */
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
        .header-title { font-size: 24px; font-weight: 600; margin-bottom: 24px; color: #111827; }

        /* --- STYLE KHUSUS TABEL (Modern Grid) --- */
        .table-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden; /* Biar sudut tabel ikut melengkung */
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        table { width: 100%; border-collapse: collapse; }

        thead { background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        
        th {
            text-align: left;
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 24px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #fafafa; }

        /* Badge & Text Styles */
        .school-name { font-weight: 600; color: #111827; display: block; }
        .school-type { font-size: 12px; color: #6b7280; background: #eff6ff; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-top: 4px; color: #4361ee; font-weight: 500; }
        
        /* Action Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        /* Tombol Terima (Awalnya soft green, hover jadi solid) */
        .btn-acc { background-color: #ecfdf5; color: #059669; }
        .btn-acc:hover { background-color: #10b981; color: white; }

        /* Tombol Tolak (Awalnya soft red, hover jadi solid) */
        .btn-rej { background-color: #fef2f2; color: #dc2626; }
        .btn-rej:hover { background-color: #ef4444; color: white; }

        /* Alert Success */
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;
            padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="fas fa-shapes"></i> HarmonyKids
        </div>

        <div class="menu-label">Menu Utama</div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('admin.validasi.index') }}" class="nav-link active">
            <i class="fas fa-check-circle"></i> Validasi Instansi
        </a>
        <a href="{{ route('admin.users') }}" class="nav-link">
            <i class="fas fa-users"></i> Data User
        </a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>

    <div class="main-content">
        <h1 class="header-title">Antrian Validasi Instansi</h1>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th width="35%">Nama Instansi & Jenis</th>
                        <th width="25%">Pengelola</th>
                        <th width="20%">Lokasi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $item)
                    <tr>
                        <td>
                            <span class="school-name">{{ $item->nama }}</span>
                            <span class="school-type">{{ $item->jenis_instansi }}</span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:30px; height:30px; background:#f3f4f6; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#9ca3af;">
                                    <i class="fas fa-user" style="font-size:12px;"></i>
                                </div>
                                {{ $item->user->name ?? 'Tanpa Nama' }}
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt" style="color:#9ca3af; margin-right:4px;"></i> 
                            {{ $item->kota }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <form action="{{ route('admin.instansi.approve', $item->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn-action btn-acc" title="Terima Pengajuan">
                                        <i class="fas fa-check"></i> Terima
                                    </button>
                                </form>

                                <form action="{{ route('admin.instansi.reject', $item->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn-action btn-rej" title="Tolak Pengajuan">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding: 40px; color: #9ca3af;">
                            <i class="fas fa-clipboard-check" style="font-size: 30px; margin-bottom: 10px; display:block;"></i>
                            Tidak ada antrian validasi saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>