<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - HarmonyKids</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- STYLE GLOBAL (SAMA DENGAN DASHBOARD) --- */
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

        /* --- TABLE STYLE (MODERN CARD) --- */
        .table-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        
        th { text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 16px 24px; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #fafafa; }

        /* --- BADGES ROLE --- */
        .role-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        
        /* Warna Badge */
        .role-admin { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; } /* Merah */
        .role-pengelola { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; } /* Biru */
        .role-wali { background: #f3e8ff; color: #9333ea; border: 1px solid #e9d5ff; } /* Ungu */

        /* User Info (Avatar + Name) */
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 36px; height: 36px; background-color: #f3f4f6; color: #6b7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600; }
        .user-details { display: flex; flex-direction: column; }
        .user-email { font-size: 12px; color: #9ca3af; }

        /* Delete Button */
        .btn-delete {
            background-color: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6;
            padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 500; transition: 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-delete:hover { background-color: #e11d48; color: white; border-color: #e11d48; }

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
        <a href="{{ route('admin.validasi.index') }}" class="nav-link">
            <i class="fas fa-check-circle"></i> Validasi Instansi
        </a>
        <a href="{{ route('admin.users') }}" class="nav-link active">
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
        <div class="header">
            <div>
                <h1 class="header-title">Data Pengguna</h1>
                <p class="header-subtitle">Kelola semua akun yang terdaftar di dalam sistem.</p>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Nama & Email</th>
                        <th width="20%">Role / Peran</th>
                        <th width="20%">Tanggal Gabung</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="text-align:center; color:#9ca3af;">{{ $loop->iteration }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <span style="font-weight: 600;">{{ $user->name }}</span>
                                    <span class="user-email">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="role-badge role-admin"><i class="fas fa-crown"></i> Admin</span>
                            @elseif($user->role == 'pengelola')
                                <span class="role-badge role-pengelola"><i class="fas fa-building"></i> Pengelola</span>
                            @else
                                <span class="role-badge role-wali"><i class="fas fa-user"></i> Wali Murid</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #4b5563;">
                                <i class="far fa-calendar-alt" style="margin-right: 5px; color:#9ca3af;"></i>
                                {{ $user->created_at->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            @if($user->id != auth()->id()) 
                                <form onsubmit="return confirm('Yakin ingin menghapus user ini?');" style="display:inline;">
                                    <button class="btn-delete" title="Hapus User">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px; color:#9ca3af; font-style:italic;">(Akun Anda)</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #9ca3af;">
                            <i class="fas fa-users-slash" style="font-size: 30px; margin-bottom: 10px; display:block;"></i>
                            Belum ada data user yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>