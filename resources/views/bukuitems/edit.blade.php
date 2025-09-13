@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Edit Buku Item</div>
        <div class="card-body">
            <form action="{{ route('bukuitems.update', $bukuitem->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Buku</label>
                    <select name="id_buku" class="form-control" required>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}" {{ $bukuitem->id_buku == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control" required>
                        <option value="baik" {{ $bukuitem->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ $bukuitem->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Tersedia" {{ $bukuitem->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Hilang" {{ $bukuitem->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        <option value="Dipinjam" {{ $bukuitem->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sumber</label>
                    <input type="text" name="sumber" class="form-control" value="{{ $bukuitem->sumber }}" required>
                </div>

                <div class="form-group">
                    <label>Rak</label>
                    <select name="id_rak" class="form-control" required>
                        @foreach($raks as $rak)
                            <option value="{{ $rak->id }}" {{ $bukuitem->id_rak == $rak->id ? 'selected' : '' }}>
                                {{ $rak->nama}}
                            </option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bukuitems.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
