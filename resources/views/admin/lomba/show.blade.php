<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - SIPRESMATU Admin</title>
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
                        <a class="nav-link active" href="{{ route('admin.lomba.index') }}">Lomba</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.laporan.index') }}">Laporan</a>
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
                        <h4 class="mb-0">Detail Lomba</h4>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama Lomba</dt>
                            <dd class="col-sm-8">{{ $lomba->nama_lomba }}</dd>

                            <dt class="col-sm-4">Deskripsi</dt>
                            <dd class="col-sm-8">{{ $lomba->deskripsi }}</dd>

                            <dt class="col-sm-4">Deadline Pendaftaran</dt>
                            <dd class="col-sm-8">{{ $lomba->deadline_pendaftaran }}</dd>

                            <dt class="col-sm-4">Tingkat Lomba</dt>
                            <dd class="col-sm-8">{{ $lomba->tingkat_lomba }}</dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                @if($lomba->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($lomba->status == 'selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @elseif($lomba->status == 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Poster</dt>
                            <dd class="col-sm-8">
                                @if($lomba->poster)
                                    <img src="{{ asset('storage/' . $lomba->poster) }}" alt="Poster Lomba" class="img-fluid rounded" style="max-width: 300px;">
                                @else
                                    <span class="text-muted">Tidak ada poster</span>
                                @endif
                            </dd>
                        </dl>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.lomba.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 