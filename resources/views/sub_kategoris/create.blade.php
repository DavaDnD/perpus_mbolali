@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Sub Kategori</h2>
        <form action="{{ route('sub_kategoris.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Sub Kategori</label>
                <input type="text" name="sub_kategori" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-2">Simpan</button>
        </form>
    </div>
@endsection
