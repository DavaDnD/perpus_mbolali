@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center pb-3">
            <div class="d-flex flex-column">
                <h3 class="card-title mb-2 pb-2">Daftar Sub Kategori</h3>
            <a href="{{ route('sub_kategoris.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>  Tambah Data</a>
            </div>
    </div>

        <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Sub Kategori</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
            @foreach($subKategoris as $sub)
                <tr>
                    <td>{{ $sub->id }}</td>
                    <td>{{ $sub->sub_kategori }}</td>
                    <td>{{ $sub->kategori->nama }}</td>
                    <td>
                        <a href="{{ route('sub_kategoris.edit', $sub->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('sub_kategoris.destroy', $sub->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Hapus sub kategori ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
@endsection
