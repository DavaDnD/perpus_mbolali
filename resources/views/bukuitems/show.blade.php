@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Buku Item</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $bukuitem->id }}</td></tr>
                <tr><th>Buku</th>
                    <td>
                        {{ $bukuitem->buku->judul }} <br>
                        Pengarang: {{ $bukuitem->buku->pengarang }} <br>
                        Tahun Terbit: {{ $bukuitem->buku->tahun_terbit }} <br>
                        ISBN: {{ $bukuitem->buku->isbn }} <br>
                        Barcode Buku: {{ $bukuitem->buku->barcode }}
                    </td>
                </tr>
                <tr><th>Kondisi</th><td>{{ ucfirst($bukuitem->kondisi) }}</td></tr>
                <tr><th>Status</th><td>{{ ucfirst($bukuitem->status) }}</td></tr>
                <tr><th>Sumber</th><td>{{ $bukuitem->sumber }}</td></tr>
                <tr><th>Barcode Item</th><td>{{ $bukuitem->barcode }}</td></tr>
                <tr><th>Tanggal Input</th><td>{{ $bukuitem->insert_date }}</td></tr>
                <tr><th>Terakhir Diubah</th><td>{{ $bukuitem->modified_date }}</td></tr>
                <tr><th>Rak</th>
                    <td>
                        {{ $bukuitem->rak->nama }} (Barcode: {{ $bukuitem->rak->barcode }})<br>
                        Kolom: {{ $bukuitem->rak->kolom }}, Baris: {{ $bukuitem->rak->baris }}<br>
                        Kapasitas: {{ $bukuitem->rak->kapasitas }}
                    </td>
                </tr>
                <tr><th>Lokasi Rak</th>
                    <td>
                       {{ $bukuitem->rak->lokasiRak->ruang }}<br>
                    </td>
                </tr>
                <tr><th>Kategori</th><td>{{ $bukuitem->rak->kategori->nama}}</td></tr>
            </table>
            <a href="{{ route('bukuitems.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
