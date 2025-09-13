@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Edit Buku</div>
        <div class="card-body">
            <form action="{{ route('bukus.update', $buku->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required>
                </div>

                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" value="{{ $buku->pengarang }}" required>
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}" required>
                </div>

                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="{{ $buku->isbn }}">
                </div>

                <div class="form-group">
                    <label>Barcode</label>
                    <input type="text" name="barcode" class="form-control" value="{{ $buku->barcode }}">
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <select name="id_penerbit" class="form-control" required>
                        @foreach($penerbits as $penerbit)
                            <option value="{{ $penerbit->id }}" {{ $buku->id_penerbit == $penerbit->id ? 'selected' : '' }}>
                                {{ $penerbit->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $buku->id_kategori == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Sub Kategori</label>
                    <select name="id_sub_kategori" class="form-control" required>
                        @foreach($subKategoris as $sub)
                            <option value="{{ $sub->id }}" {{ $buku->id_sub_kategori == $sub->id ? 'selected' : '' }}>
                                {{ $sub->sub_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bukus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
