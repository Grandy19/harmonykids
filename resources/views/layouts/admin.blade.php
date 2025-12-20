<!DOCTYPE html>
<html>
<head>
    <title>Admin HarmonyKids</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { height: 100vh; background: #2c3e50; padding-top: 20px; }
        .sidebar a { display: block; color: white; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover { background: #34495e; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar col-md-2">
            <h4 class="text-white text-center mb-4">Admin Panel</h4>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.instansi') }}"><i class="fas fa-school"></i> Data Instansi</a>
            <a href="{{ route('admin.users') }}"><i class="fas fa-users"></i> Pengguna</a>
            <a href="{{ route('admin.forums') }}"><i class="fas fa-comments"></i> Postingan</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-5 px-3">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
        <div class="col-md-10 p-4 bg-light">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>