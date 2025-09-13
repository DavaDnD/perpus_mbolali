@extends('layouts.app')

@section('content')
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center pb-3">
            <!-- Kiri: Judul + Tombol (stacked) -->
            <div class="d-flex flex-column">
                <h3 class="card-title mb-2 pb-2">Daftar Rak</h3>
        <a href="{{ route('raks.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>  Tambah Data</a>
            </div>
        </div>

        <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Barcode</th>
                <th>Nama</th>
                <th>Kolom</th>
                <th>Baris</th>
                <th>Kapasitas</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($raks as $rak)
                <tr>
                    <td>{{ $rak->barcode }}</td>
                    <td>{{ $rak->nama }}</td>
                    <td>{{ $rak->kolom }}</td>
                    <td>{{ $rak->baris }}</td>
                    <td>{{ $rak->kapasitas }}</td>
                    <td>{{ $rak->lokasi->ruang ?? '-' }}</td>
                    <td>{{ $rak->kategori->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('raks.edit', $rak->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('raks.destroy', $rak->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus rak ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
