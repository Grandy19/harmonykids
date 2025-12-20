<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - HarmonyKids</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- RESET DASAR --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background-color: #f9fafb; /* Abu-abu sangat muda (biar konten putih lebih pop-up) */
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR (KIRI) --- */
        .sidebar {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb; /* Garis tipis pemisah */
            position: fixed;
            height: 100%;
            padding: 24px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            font-size: 20px;
            font-weight: 600;
            color: #4361ee; /* Warna Biru Utama */
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-label {
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s;
            font-size: 14px;
        }

        .nav-link:hover {
            background-color: #f3f4f6;
            color: #4361ee;
        }

        .nav-link.active {
            background-color: #eff6ff;
            color: #4361ee;
            font-weight: 500;
        }

        /* --- KONTEN UTAMA (KANAN) --- */
        .main-content {
            margin-left: 250px; /* Sesuai lebar sidebar */
            padding: 32px;
            width: 100%;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #111827;
        }

        /* --- KARTU STATISTIK (GRID) --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }

        .card {
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e5e7eb; /* Border halus */
            box-shadow: 0 1px 2px rgba(0,0,0,0.05); /* Bayangan sangat tipis */
        }

        .card-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .card-number {
            font-size: 32px;
            font-weight: 600;
            color: #111827;
        }

        .logout-btn {
            margin-top: auto; /* Dorong ke paling bawah */
            border: none;
            background: none;
            cursor: pointer;
            color: #ef4444; /* Merah */
            width: 100%;
            text-align: left;
        }
        
        .logout-btn:hover {
            background-color: #fef2f2;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="fas fa-shapes"></i> HarmonyKids
        </div>

        <div class="menu-label">Menu Utama</div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('admin.validasi.index') }}" class="nav-link">
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
        <h1 class="header-title">Dashboard Overview</h1>

        <div class="stats-grid">
            
            <div class="card">
                <div class="card-title">Menunggu Validasi</div>
                <div class="card-number" style="color: #f59e0b;">
                    {{ $totalPending }}
                </div>
            </div>

            <div class="card">
                <div class="card-title">Instansi Aktif</div>
                <div class="card-number" style="color: #10b981;">
                    {{ $totalAktif }}
                </div>
            </div>

            <div class="card">
                <div class="card-title">Total Pengelola</div>
                <div class="card-number" style="color: #3b82f6;">
                    {{ $totalUser }}
                </div>
            </div>

        </div>
    </div>

</body>
</html>