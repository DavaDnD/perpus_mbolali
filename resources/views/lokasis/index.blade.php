@extends('layouts.app')

@section('content')
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center pb-3">
            <!-- Kiri: Judul + Tombol (stacked) -->
            <div class="d-flex flex-column">
                <h3 class="card-title mb-2 pb-2">Lokasi Perpus</h3>
        <a href="{{ route('lokasis.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>  Tambah Data</a>
            </div>
        </div>

        <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ruang</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lokasis as $lokasi)
                <tr>
                    <td>{{ $lokasi->id }}</td>
                    <td>{{ $lokasi->ruang }}</td>
                    <td>
                        <a href="{{ route('lokasis.edit', $lokasi->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('lokasis.destroy', $lokasi->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus lokasi ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
