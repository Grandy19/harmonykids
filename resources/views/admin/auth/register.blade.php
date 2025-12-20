<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengelola - HarmonyKids</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- COPY STYLE DARI LOGIN BIAR SAMA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px; /* Sedikit lebih lebar dari login karena field lebih banyak */
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand {
            font-size: 26px;
            font-weight: 700;
            color: #4361ee;
            margin-bottom: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .subtitle { color: #9ca3af; font-size: 14px; margin-bottom: 25px; }

        /* --- INPUT FIELDS --- */
        .input-group { position: relative; margin-bottom: 15px; text-align: left; }
        
        .input-group i {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 14px; transition: 0.3s;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
            background: #f9fafb;
            color: #333;
        }

        input:focus {
            border-color: #4361ee; background: #fff;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }
        input:focus + i { color: #4361ee; }

        /* --- BUTTON --- */
        .btn-submit {
            width: 100%; padding: 14px; background: #4361ee; color: white;
            border: none; border-radius: 10px; cursor: pointer;
            font-weight: 600; font-size: 15px; transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        .btn-submit:hover {
            background: #3f37c9; transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }

        /* --- FOOTER LINK --- */
        .footer-text { margin-top: 25px; font-size: 13px; color: #6b7280; }
        .footer-text a { color: #4361ee; text-decoration: none; font-weight: 600; }
        .footer-text a:hover { text-decoration: underline; }

        /* --- ERROR BOX --- */
        .error-msg {
            background: #fee2e2; color: #b91c1c; padding: 12px;
            border-radius: 8px; font-size: 13px; margin-bottom: 20px;
            text-align: left; display: flex; align-items: center; gap: 10px;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="brand">
            <i class="fas fa-shapes"></i> HarmonyKids
        </div>
        <p class="subtitle">Buat akun untuk mengelola sekolah Anda</p>

        @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Terjadi Kesalahan:</strong><br>
                    {{ $errors->first() }}
                </div>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Nama Lengkap Pengelola" required value="{{ old('name') }}">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Alamat Email Aktif" required value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password Baru" required>
            </div>

            <div class="input-group">
                <i class="fas fa-check-circle"></i>
                <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
            </div>
            
            <button type="submit" class="btn-submit">
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="footer-text">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk disini</a>
        </div>
    </div>

</body>
</html>