<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Prestasi Mahasiswa - SIPRESMATU</title>
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
                        <a class="nav-link active" href="{{ route('admin.prestasi.index') }}">Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.lomba.index') }}">Lomba</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Daftar Prestasi Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nama Lomba</th>
                                        <th>Juara</th>
                                        <th>Tingkat</th>
                                        <th>Tanggal</th>
                                        <th>Bukti</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestasis as $prestasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $prestasi->mahasiswa->nama ?? '-' }}</td>
                                            <td>{{ $prestasi->nama_lomba }}</td>
                                            <td>{{ $prestasi->juara ?? '-' }}</td>
                                            <td>{{ $prestasi->tingkat_lomba ?? '-' }}</td>
                                            <td>{{ $prestasi->tanggal ? \Carbon\Carbon::parse($prestasi->tanggal)->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                @if($prestasi->bukti)
                                                    <a href="{{ asset('storage/' . $prestasi->bukti) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($prestasi->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($prestasi->status == 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif($prestasi->status == 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($prestasi->status == 'pending')
                                                    <form action="{{ route('admin.prestasi.approve', $prestasi->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve prestasi ini?')">
                                                            <i class="bi bi-check-circle"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.prestasi.reject', $prestasi->id) }}" method="POST" class="d-inline ms-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject prestasi ini?')">
                                                            <i class="bi bi-x-circle"></i> Reject
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada data prestasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 