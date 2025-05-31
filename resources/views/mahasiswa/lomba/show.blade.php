<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - SIPRESMATU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">SIPRESMATU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mahasiswa.prestasi.index') }}">Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('mahasiswa.lomba.index') }}">Lomba</a>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Lomba</h4>
                        <div>
                            @if($lomba->status === 'aktif')
                                <form action="{{ route('mahasiswa.lomba.daftar', $lomba) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i> Daftar Lomba
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($lomba->gambar)
                            <img src="{{ Storage::url($lomba->gambar) }}" alt="{{ $lomba->nama }}" class="img-fluid rounded mb-4">
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Nama Lomba</div>
                            <div class="col-md-8">{{ $lomba->nama_lomba }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Deadline Pendaftaran</div>
                            <div class="col-md-8">
                                @if($lomba->deadline_pendaftaran)
                                    {{ \Carbon\Carbon::parse($lomba->deadline_pendaftaran)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tingkat Lomba</div>
                            <div class="col-md-8">{{ $lomba->tingkat_lomba }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Deskripsi</div>
                            <div class="col-md-8">{{ $lomba->deskripsi }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Poster</div>
                            <div class="col-md-8">
                                @if($lomba->poster)
                                    <img src="{{ asset('storage/' . $lomba->poster) }}" alt="Poster Lomba" class="img-fluid rounded" style="max-width: 300px;">
                                @else
                                    <span class="text-muted">Tidak ada poster</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Status</div>
                            <div class="col-md-8">
                                @if($lomba->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($lomba->status === 'selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @elseif($lomba->status === 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>
                        </div>

                        @if($lomba->file_panduan)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">File Panduan</div>
                                <div class="col-md-8">
                                    <a href="{{ Storage::url($lomba->file_panduan) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download Panduan
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('mahasiswa.lomba.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 