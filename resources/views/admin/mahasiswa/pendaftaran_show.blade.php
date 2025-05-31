<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran Lomba - SIPRESMATU Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">SIPRESMATU Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.prestasi.index') }}">Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.lomba.index') }}">Lomba</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Detail Pendaftaran Lomba</h4>
                    </div>
                    <div class="card-body">
                        <h5>Data Mahasiswa</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Nama</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->mahasiswa->nama ?? '-' }}</dd>
                            <dt class="col-sm-4">NIM</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->mahasiswa->nim ?? '-' }}</dd>
                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->mahasiswa->email ?? '-' }}</dd>
                            <dt class="col-sm-4">Jurusan</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->jurusan ?? '-' }}</dd>
                            <dt class="col-sm-4">Fakultas</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->fakultas ?? '-' }}</dd>
                            <dt class="col-sm-4">No. Telepon</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->no_telp ?? '-' }}</dd>
                        </dl>
                        <hr>
                        <h5>Data Lomba</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Nama Lomba</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->lomba->nama_lomba ?? '-' }}</dd>
                            <dt class="col-sm-4">Tingkat</dt>
                            <dd class="col-sm-8">{{ $pendaftaran->lomba->tingkat_lomba ?? '-' }}</dd>
                        </dl>
                        <hr>
                        <h5>Anggota Tim</h5>
                        @php $adaAnggota = false; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($pendaftaran["anggota{$i}_nama"])
                                @php $adaAnggota = true; @endphp
                                <div class="border rounded p-3 mb-3">
                                    <strong>Anggota {{ $i }}</strong><br>
                                    Nama: {{ $pendaftaran["anggota{$i}_nama"] }}<br>
                                    NIM: {{ $pendaftaran["anggota{$i}_nim"] }}<br>
                                    Jurusan: {{ $pendaftaran["anggota{$i}_jurusan"] }}<br>
                                    Fakultas: {{ $pendaftaran["anggota{$i}_fakultas"] }}<br>
                                    No. Telepon: {{ $pendaftaran["anggota{$i}_no_telp"] }}
                                </div>
                            @endif
                        @endfor
                        @if(!$adaAnggota)
                            <p class="text-muted">Tidak ada anggota tim.</p>
                        @endif
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 