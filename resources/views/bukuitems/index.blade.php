@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center pb-3">
            <!-- Kiri: Judul + Tombol (stacked) -->
            <div class="d-flex flex-column">
                <h3 class="card-title mb-2 pb-2">Daftar Eksemplar</h3>
                <a href="{{ route('bukuitems.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>  Tambah Data
                </a>
            </div>

            <!-- Search Box -->
            <div class="position-relative mt-5" style="width: 320px;">
                <div class="input-group">
            <span class="input-group-text bg-light border-0 rounded-start-pill">
                <i class="bi bi-search text-muted"></i>
            </span>
                    <input type="text" id="search-item"
                           class="form-control border-0 shadow-sm rounded-end-pill"
                           placeholder="Cari Eksemplar..."
                           style="background-color: #f0f2f5;">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Buku</th>
                    <th>Rak</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="bukuitem-list">
                @foreach($bukuitems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->rak->nama }}</td>
                        <td>{{ $item->kondisi }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('bukuitems.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('bukuitems.edit', $item->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('bukuitems.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $bukuitems->links() }}
            </div>


        </div>
    </div>


@endsection
