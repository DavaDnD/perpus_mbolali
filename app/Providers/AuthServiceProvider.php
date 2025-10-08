<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// import semua model
use App\Models\Buku;
use App\Models\BukuItem;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Rak;
use App\Models\LokasiRak;
use App\Models\Penerbit;

// import semua policy
use App\Policies\BukuPolicy;
use App\Policies\BukuItemPolicy;
use App\Policies\KategoriPolicy;
use App\Policies\SubKategoriPolicy;
use App\Policies\RakPolicy;
use App\Policies\LokasiRakPolicy;
use App\Policies\PenerbitPolicy;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Buku::class => BukuPolicy::class,
        BukuItem::class => BukuItemPolicy::class,
        Kategori::class => KategoriPolicy::class,
        SubKategori::class => SubKategoriPolicy::class,
        Rak::class => RakPolicy::class,
        LokasiRak::class => LokasiRakPolicy::class,
        Penerbit::class => PenerbitPolicy::class,
        Tatarak::class => TatarakPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
