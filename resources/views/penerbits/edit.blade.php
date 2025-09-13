@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Penerbit</h2>
        <form action="{{ route('penerbits.update', $penerbit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $penerbit->nama) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $penerbit->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">No Telepon</label>
                <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $penerbit->no_telepon) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $penerbit->email) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('penerbits.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
