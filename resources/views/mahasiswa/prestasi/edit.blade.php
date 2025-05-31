<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prestasi - SIPRESMATU</title>
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
                    <div class="card-header">
                        <h4 class="mb-0">Edit Prestasi</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('mahasiswa.prestasi.update', $prestasi) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_lomba" class="form-label">Nama Lomba</label>
                                <input type="text" class="form-control" id="nama_lomba" name="nama_lomba" value="{{ old('nama_lomba', $prestasi->nama_lomba) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="juara" class="form-label">Juara</label>
                                <select class="form-select" id="juara" name="juara" required>
                                    <option value="">Pilih Juara</option>
                                    <option value="Juara 1" {{ old('juara', $prestasi->juara) == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                                    <option value="Juara 2" {{ old('juara', $prestasi->juara) == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                                    <option value="Juara 3" {{ old('juara', $prestasi->juara) == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                                    <option value="Harapan 1" {{ old('juara', $prestasi->juara) == 'Harapan 1' ? 'selected' : '' }}>Harapan 1</option>
                                    <option value="Harapan 2" {{ old('juara', $prestasi->juara) == 'Harapan 2' ? 'selected' : '' }}>Harapan 2</option>
                                    <option value="Harapan 3" {{ old('juara', $prestasi->juara) == 'Harapan 3' ? 'selected' : '' }}>Harapan 3</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tingkat_lomba" class="form-label">Tingkat Lomba</label>
                                <select class="form-select" id="tingkat_lomba" name="tingkat_lomba" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="Nasional" {{ old('tingkat_lomba', $prestasi->tingkat_lomba) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Provinsi" {{ old('tingkat_lomba', $prestasi->tingkat_lomba) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                    <option value="Kabupaten/Kota" {{ old('tingkat_lomba', $prestasi->tingkat_lomba) == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                    <option value="Kampus" {{ old('tingkat_lomba', $prestasi->tingkat_lomba) == 'Kampus' ? 'selected' : '' }}>Kampus</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="bukti" class="form-label">Bukti Prestasi (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="bukti" name="bukti">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah bukti prestasi</small>
                                @if($prestasi->bukti)
                                    <div class="mt-2">
                                        <p class="mb-1">Bukti saat ini:</p>
                                        @php
                                            $extension = pathinfo($prestasi->bukti, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <img src="{{ Storage::url($prestasi->bukti) }}" alt="Bukti Prestasi" class="img-fluid mb-2" style="max-height: 200px;">
                                        @endif
                                        <a href="{{ Storage::url($prestasi->bukti) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="bi bi-download"></i> Download Bukti
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('mahasiswa.prestasi.show', $prestasi) }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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