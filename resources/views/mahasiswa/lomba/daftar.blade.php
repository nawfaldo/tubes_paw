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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Formulir Pendaftaran Lomba</h4>
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
                        <form action="{{ route('mahasiswa.lomba.daftar', $lomba) }}" method="POST">
                            @csrf
                            <h5>Data Diri</h5>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ Auth::guard('mahasiswa')->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control" value="{{ Auth::guard('mahasiswa')->user()->nim }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" name="jurusan" value="{{ Auth::guard('mahasiswa')->user()->jurusan }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fakultas</label>
                                <input type="text" class="form-control" name="fakultas" value="{{ Auth::guard('mahasiswa')->user()->fakultas }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" name="no_telp" value="{{ Auth::guard('mahasiswa')->user()->no_telp }}" required>
                            </div>
                            <hr>
                            <h5>Anggota (Opsional)</h5>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Anggota</label>
                                <select class="form-select" id="jumlah_anggota" name="jumlah_anggota">
                                    @for($i = 0; $i <= ($lomba->max_anggota ?? 0); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div id="anggota-fields"></div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('mahasiswa.lomba.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const anggotaFields = document.getElementById('anggota-fields');
            const jumlahAnggota = document.getElementById('jumlah_anggota');
            anggotaFields.innerHTML = '';
            jumlahAnggota.addEventListener('change', function() {
                anggotaFields.innerHTML = '';
                const jumlah = parseInt(this.value);
                for (let i = 1; i <= jumlah; i++) {
                    anggotaFields.innerHTML += `
                        <div class="border rounded p-3 mb-3">
                            <h6>Anggota ${i}</h6>
                            <div class="mb-2">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="anggota${i}_nama" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control" name="anggota${i}_nim" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" name="anggota${i}_jurusan" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Fakultas</label>
                                <input type="text" class="form-control" name="anggota${i}_fakultas" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" name="anggota${i}_no_telp" required>
                            </div>
                        </div>
                    `;
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 