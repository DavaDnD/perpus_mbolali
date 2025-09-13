@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Buku Item</div>
        <div class="card-body">
            <form action="{{ route('bukuitems.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Buku</label>
                    <select name="id_buku" class="form-control" required>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Hilang">Hilang</option>
                        <option value="Dipinjam">Dipinjam</option>
                    </select>
                </div>

                <div class="form-group">
                    <lab>Sumber</lab>
                    <input type="text" name="sumber" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Rak</label>
                    <select name="id_rak" class="form-control" required>
                        @foreach($raks as $rak)
                            <option value="{{ $rak->id }}">{{ $rak->nama}}</option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('bukuitems.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
