@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Lokasi Rak</h2>
        <form action="{{ route('lokasis.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="ruang" class="form-label">Ruang</label>
                <input type="text" name="ruang" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('lokasis.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
