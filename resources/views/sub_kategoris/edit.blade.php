@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Sub Kategori</h2>
        <form action="{{ route('sub_kategoris.update', $subKategori->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Sub Kategori</label>
                <input type="text" name="sub_kategori" value="{{ $subKategori->sub_kategori }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $subKategori->id_kategori == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-2">Update</button>
        </form>
    </div>
@endsection
