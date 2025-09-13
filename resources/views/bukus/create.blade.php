@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Buku</div>
        <div class="card-body">
            <form action="{{ route('bukus.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control">
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <select name="id_penerbit" class="form-control" required>
                        @foreach($penerbits as $penerbit)
                            <option value="{{ $penerbit->id }}">{{ $penerbit->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>SubKategori</label>
                    <select name="id_sub_kategori" class="form-control" required>
                        @foreach($subKategoris as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->sub_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('bukus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
