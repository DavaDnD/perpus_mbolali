<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\BukuPolicy;
use App\Policies\BukuItemPolicy;
use App\Policies\KategoriPolicy;
use App\Policies\SubKategoriPolicy;
use App\Policies\RakPolicy;
use App\Policies\LokasiRakPolicy;
use App\Policies\PenerbitPolicy;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        \App\Models\Buku::class => \App\Policies\BukuPolicy::class,
        \App\Models\BukuItem::class => \App\Policies\BukuItemPolicy::class,
        \App\Models\Kategori::class => \App\Policies\KategoriPolicy::class,
        \App\Models\SubKategori::class => \App\Policies\SubKategoriPolicy::class,
        \App\Models\Rak::class => \App\Policies\RakPolicy::class,
        \App\Models\LokasiRak::class => \App\Policies\LokasiRakPolicy::class,
        \App\Models\Penerbit::class => \App\Policies\PenerbitPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
