@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <img src="{{ asset('images/logo-remenmaos.png') }}" alt="Logo Remen Maos" width="150" class="mb-3">
            <h1 class="fw-bold">Perpustakaan Remen Maos</h1>
            <h5 class="text-muted">Boyolali, Jawa Tengah</h5>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">Tentang Kami</h4>
                        <p>
                            Perpustakaan <strong>Remen Maos</strong> merupakan pusat literasi masyarakat Boyolali
                            yang didirikan pada tahun <strong>2004</strong>.
                            Nama “Remen Maos” berasal dari bahasa Jawa yang berarti
                            <em>“senang membaca”</em>, sebagai wujud semangat masyarakat
                            dalam mengembangkan budaya literasi.
                        </p>
                        <p>
                            Alamat: <br>
                            <strong>Jl. Pandanaran No. 45, Boyolali, Jawa Tengah</strong>
                        </p>
                        <p>
                            Sejak berdiri, perpustakaan ini telah menjadi wadah pembelajaran,
                            diskusi, serta ruang tumbuh bagi pelajar dan masyarakat sekitar.
                        </p>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <blockquote class="blockquote">
                        <p class="mb-0">📚 “Membaca adalah jendela dunia, dan kami membuka jendela itu untuk semua.”</p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
@endsection
