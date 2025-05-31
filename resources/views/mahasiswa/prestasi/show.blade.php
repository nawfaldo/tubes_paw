<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prestasi - SIPRESMATU</title>
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
                        <a class="nav-link active" href="{{ route('mahasiswa.prestasi.index') }}">Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mahasiswa.lomba.index') }}">Lomba</a>
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
                        <h4 class="mb-0">Detail Prestasi</h4>
                        <div>
                            @if($prestasi->status === 'pending')
                                <a href="{{ route('mahasiswa.prestasi.edit', $prestasi) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('mahasiswa.prestasi.destroy', $prestasi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Nama Lomba</div>
                            <div class="col-md-8">{{ $prestasi->nama_lomba }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Juara</div>
                            <div class="col-md-8">{{ $prestasi->juara }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tingkat Lomba</div>
                            <div class="col-md-8">{{ $prestasi->tingkat_lomba }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tanggal</div>
                            <div class="col-md-8">{{ $prestasi->tanggal->format('d/m/Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Status</div>
                            <div class="col-md-8">
                                @if($prestasi->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($prestasi->status === 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Deskripsi</div>
                            <div class="col-md-8">{{ $prestasi->deskripsi ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Bukti Prestasi</div>
                            <div class="col-md-8">
                                @if($prestasi->bukti)
                                    @php
                                        $extension = pathinfo($prestasi->bukti, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($prestasi->bukti) }}" alt="Bukti Prestasi" class="img-fluid mb-2" style="max-height: 300px;">
                                    @endif
                                    <a href="{{ Storage::url($prestasi->bukti) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download Bukti
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('mahasiswa.prestasi.index') }}" class="btn btn-secondary">
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