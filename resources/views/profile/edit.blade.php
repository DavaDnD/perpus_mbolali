<!-- resources/views/profile/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Profil</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input id="name" type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Foto Profil -->
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Profil (jpg/png)</label>
                @if(Auth::user()->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                             alt="Profile" class="rounded-circle" width="100" height="100">
                    </div>
                @else
                    <div class="mb-2">
                        <img src="{{ asset('images/default.png') }}"
                             alt="Default" class="rounded-circle" width="100" height="100">
                    </div>
                @endif
                <input id="photo" type="file" name="photo"
                       class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password baru -->
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (opsional)</label>
                <input id="password" type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>


    </div>
@endsection
