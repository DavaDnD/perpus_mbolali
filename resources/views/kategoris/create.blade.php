@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Kategori</h2>
        <form action="{{ route('kategoris.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Simpan</button>
        </form>
    </div>
@endsection
