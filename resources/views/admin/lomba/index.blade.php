<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lomba - SIPRESMATU Admin</title>
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
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Daftar Lomba</h4>
                        <a href="{{ route('admin.lomba.create') }}" class="btn btn-light text-success">
                            <i class="bi bi-plus-circle"></i> Tambah Lomba
                        </a>
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
                                        <th>Nama Lomba</th>
                                        <th>Deskripsi</th>
                                        <th>Deadline</th>
                                        <th>Tingkat</th>
                                        <th>Poster</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tingkatOptions = [
                                            'Universitas' => 'Universitas',
                                            'Kabupaten/Kota' => 'Kabupaten/Kota',
                                            'Provinsi' => 'Provinsi',
                                            'Nasional' => 'Nasional',
                                            'Internasional' => 'Internasional',
                                        ];
                                    @endphp
                                    @forelse($lombas as $lomba)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lomba->nama_lomba }}</td>
                                            <td>{{ Str::limit($lomba->deskripsi, 50) }}</td>
                                            <td>{{ $lomba->deadline_pendaftaran ? \Carbon\Carbon::parse($lomba->deadline_pendaftaran)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $tingkatOptions[$lomba->tingkat_lomba] ?? $lomba->tingkat_lomba }}</td>
                                            <td>
                                                @if($lomba->poster)
                                                    <img src="{{ asset('storage/' . $lomba->poster) }}" alt="Poster" style="max-width: 60px; max-height: 60px;">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($lomba->status == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @elseif($lomba->status == 'selesai')
                                                    <span class="badge bg-primary">Selesai</span>
                                                @elseif($lomba->status == 'dibatalkan')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.lomba.show', $lomba->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('admin.lomba.edit', $lomba->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('admin.lomba.destroy', $lomba->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lomba ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data lomba.</td>
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