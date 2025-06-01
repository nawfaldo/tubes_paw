<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lomba - SIPRESMATU</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Lomba</h2>
        </div>

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

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($lombas as $lomba)
                <div class="col">
                    <div class="card h-100">
                        @if($lomba->poster)
                            <img src="{{ asset('storage/' . $lomba->poster) }}" class="card-img-top" alt="{{ $lomba->nama_lomba }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-trophy fs-1 text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $lomba->nama_lomba }}</h5>
                            <p class="card-text text-muted mb-1">
                                <i class="bi bi-calendar"></i> 
                                @if($lomba->deadline_pendaftaran)
                                    {{ \Carbon\Carbon::parse($lomba->deadline_pendaftaran)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </p>
                            <p class="card-text text-muted mb-1">
                                <i class="bi bi-people"></i> Maks. {{ $lomba->max_anggota }} peserta
                            </p>
                            <p class="card-text text-muted mb-1">
                                <i class="bi bi-award"></i> {{ $lomba->tingkat_lomba }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('mahasiswa.lomba.show', $lomba) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                @if($lomba->status === 'aktif')
                                    <a href="{{ route('mahasiswa.lomba.daftar.form', $lomba) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil-square"></i> Daftar
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada lomba yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 