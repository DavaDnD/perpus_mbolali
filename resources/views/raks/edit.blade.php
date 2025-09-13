@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Rak</h2>
        <form action="{{ route('raks.update', $rak->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Barcode</label>
                <input type="text" name="barcode" class="form-control" value="{{ $rak->barcode }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ $rak->nama }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kolom</label>
                <input type="number" name="kolom" class="form-control" value="{{ $rak->kolom }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Baris</label>
                <input type="number" name="baris" class="form-control" value="{{ $rak->baris }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" value="{{ $rak->kapasitas }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <select name="id_lokasi" class="form-control" required>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}" {{ $rak->id_lokasi == $lokasi->id ? 'selected' : '' }}>
                            {{ $lokasi->ruang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $rak->id_kategori == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('raks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
