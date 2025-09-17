@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center pb-3"
             style="background-color: #dee2e6;">

            <!-- Kiri: Judul + Tombol -->
            <div class="d-flex flex-column">
                <h3 class="card-title mb-2 pb-2" style="color: #212529;">Daftar Buku</h3>
                <a href="{{ route('bukus.create') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>

            <!-- Search Box -->
            <div class="position-relative mt-5" style="width: 320px;">
                <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-0 rounded-start-pill text-muted">
                <i class="bi bi-search"></i>
            </span>
                    <input type="text" id="search"
                           class="form-control border-0 rounded-end-pill"
                           placeholder="Cari buku..."
                           style="background-color: #f8f9fa; color: #212529;">
                </div>
            </div>
        </div>



        <div class="card-body">
            <table class="table table-bordered datatable custom-table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penerbit</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="buku-list">
                @foreach($bukus as $buku)
                    <tr>
                        <td>{{ $buku->id }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penerbit->nama }}</td>
                        <td class="text-center items-center">
                            <a href="{{ route('bukus.show', $buku->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('bukus.edit', $buku->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $bukus->links('vendor.pagination.bootstrap-5') }}
        </div>


    </div>
    </div>
    </div>

@endsection
