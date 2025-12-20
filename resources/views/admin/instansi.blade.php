@extends('layouts.admin')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Instansi Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instansi.store') }}" method="POST">
            @csrf
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label>Nama Instansi</label>
                    <input type="text" name="nama_instansi" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection