@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Buku</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $buku->id }}</td></tr>
                <tr><th>Judul</th><td>{{ $buku->judul }}</td></tr>
                <tr><th>Pengarang</th><td>{{ $buku->pengarang }}</td></tr>
                <tr><th>Tahun Terbit</th><td>{{ $buku->tahun_terbit }}</td></tr>
                <tr><th>ISBN</th><td>{{ $buku->isbn }}</td></tr>
                <tr><th>Barcode</th><td>{{ $buku->barcode }}</td></tr>
                <tr><th>Penerbit</th>
                    <td>
                        {{ $buku->penerbit->nama }}<br>
                        Alamat: {{ $buku->penerbit->alamat }}<br>
                        Telepon: {{ $buku->penerbit->no_telepon }}<br>
                        Email: {{ $buku->penerbit->email }}
                    </td>
                </tr>
                <tr><th>Kategori</th><td>{{ $buku->kategori->nama}}</td></tr>
                <tr><th>Sub Kategori</th><td>{{ $buku->subKategori->sub_kategori }}</td></tr>
            </table>
            <a href="{{ route('bukus.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('bukuitems.search', $buku->id) }}" class="btn btn-sm btn-primary">
                Cari Eksemplar
            </a>


        </div>
    </div>
@endsection
