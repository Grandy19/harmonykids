@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Kelola Instansi</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Instansi
    </button>
</div>

<div class="mb-3">
    Urutkan Harga: 
    <a href="?sort=termurah" class="btn btn-sm btn-outline-success">Terendah</a>
    <a href="?sort=termahal" class="btn btn-sm btn-outline-danger">Tertinggi</a>
    <a href="{{ route('admin.instansi') }}" class="btn btn-sm btn-secondary">Reset</a>
</div>

<div class="card shadow">
    <table class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Biaya</th>
                <th>Status Populer</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instansis as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis_instansi }}</td>
                <td>Rp {{ number_format($item->biaya_angka) }}</td>
                <td>
                    <form action="{{ route('admin.instansi.popular', $item->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm {{ $item->is_popular ? 'btn-warning' : 'btn-outline-secondary' }}">
                            <i class="fas fa-star"></i> {{ $item->is_popular ? 'Populer' : 'Biasa' }}
                        </button>
                    </form>
                </td>
                <td>
                   <button class="btn btn-sm btn-info text-white">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('admin.instansi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Data</h5></div>
                <div class="modal-body">
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Instansi" required>
                    <select name="jenis_instansi" class="form-control mb-2">
                        <option value="TK">TK</option>
                        <option value="Daycare">Daycare</option>
                    </select>
                    <input type="number" name="biaya_angka" class="form-control mb-2" placeholder="Biaya (Angka)" required>
                    <input type="text" name="biaya_display" class="form-control mb-2" placeholder="Teks Biaya (mis: Rp 500rb/bln)">
                    <input type="text" name="kota" class="form-control mb-2" placeholder="Kota">
                    <label>Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control mb-2">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection