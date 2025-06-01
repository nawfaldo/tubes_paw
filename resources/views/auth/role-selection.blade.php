<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran - SIPRESMATU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <h1 class="mb-4">SIPRESMATU</h1>
                        <h2 class="h4 mb-4">Sistem Pelaporan Prestasi dan Perlombaan Telkom University</h2>
                        <p class="mb-4">Silakan pilih peran Anda untuk melanjutkan:</p>
                        
                        <div class="d-grid gap-3">
                            <a href="{{ route('login', 'mahasiswa') }}" class="btn btn-primary btn-lg">
                                Masuk sebagai Mahasiswa
                            </a>
                            <a href="{{ route('login', 'admin') }}" class="btn btn-success btn-lg">
                                Masuk sebagai Admin
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <p>Belum punya akun? <a href="{{ route('register', 'mahasiswa') }}">Daftar sebagai Mahasiswa</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 