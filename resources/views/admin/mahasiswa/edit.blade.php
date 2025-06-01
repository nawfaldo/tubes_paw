<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran Lomba - SIPRESMATU Admin</title>
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
                        <h4 class="mb-0">Edit Pendaftaran Lomba</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.mahasiswa.pendaftaran.update', $pendaftaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                                <select class="form-select @error('mahasiswa_id') is-invalid @enderror" 
                                    id="mahasiswa_id" name="mahasiswa_id" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach($mahasiswas as $mahasiswa)
                                        <option value="{{ $mahasiswa->id }}" 
                                            {{ old('mahasiswa_id', $pendaftaran->mahasiswa_id) == $mahasiswa->id ? 'selected' : '' }}>
                                            {{ $mahasiswa->nim }} - {{ $mahasiswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="lomba_id" class="form-label">Lomba</label>
                                <select class="form-select @error('lomba_id') is-invalid @enderror" 
                                    id="lomba_id" name="lomba_id" required>
                                    <option value="">Pilih Lomba</option>
                                    @foreach($lombas as $lomba)
                                        <option value="{{ $lomba->id }}" 
                                            {{ old('lomba_id', $pendaftaran->lomba_id) == $lomba->id ? 'selected' : '' }}>
                                            {{ $lomba->nama_lomba }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                    id="jurusan" name="jurusan" value="{{ old('jurusan', $pendaftaran->jurusan) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="fakultas" class="form-label">Fakultas</label>
                                <input type="text" class="form-control @error('fakultas') is-invalid @enderror" 
                                    id="fakultas" name="fakultas" value="{{ old('fakultas', $pendaftaran->fakultas) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                    id="no_telp" name="no_telp" value="{{ old('no_telp', $pendaftaran->no_telp) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                    <option value="pending" {{ old('status', $pendaftaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diterima" {{ old('status', $pendaftaran->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak" {{ old('status', $pendaftaran->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 