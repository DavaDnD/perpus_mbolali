@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Lokasi Rak</h2>
        <form action="{{ route('lokasis.update', $lokasi->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="ruang" class="form-label">Ruang</label>
                <input type="text" name="ruang" class="form-control" value="{{ $lokasi->ruang }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('lokasis.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
