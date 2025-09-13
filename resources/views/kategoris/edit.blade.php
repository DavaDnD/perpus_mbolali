@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Kategori</h2>
        <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama" value="{{ $kategori->nama }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Update</button>
        </form>
    </div>
@endsection
