@extends('layouts.app')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center pb-3"
         style="background-color: #dee2e6;">

        <div class="d-flex flex-column">
            <h3 class="card-title mb-2 pb-2">Daftar Kategori</h3>
        <a href="{{ route('kategoris.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>  Tambah Data</a>
        </div>
    </div>

        <div class="card-body">
            <table class="table table-bordered datatable custom-table table-striped">
                <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
                </thead>
            @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->id }}</td>
                    <td>{{ $kategori->nama }}</td>
                    <td class="text-center">
                        @can('update', $kategori)
                        <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                        @endcan
                            @can('delete', $kategori)
                            <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Hapus kategori ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                            @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

</div>
@endsection
