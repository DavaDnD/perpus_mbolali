@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Rak</h2>
        <form action="{{ route('raks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Barcode</label>
                <input type="text" name="barcode" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kolom</label>
                <input type="number" name="kolom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Baris</label>
                <input type="number" name="baris" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <select name="id_lokasi" class="form-control" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->ruang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('raks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
