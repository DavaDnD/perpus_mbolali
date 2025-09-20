<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Remen Maos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        .custom-table tbody tr {
            border-bottom: 2px solid #dee2e6;
        }

        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #c2c7d0;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .content-wrapper {
            padding: 20px;
        }

        .custom-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 50px;
            padding: 10px 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            gap: 10px;
        }

        .custom-pagination .page-item { list-style: none; }

        .custom-pagination .page-link {
            border: none !important;
            background: transparent !important;
            color: #333 !important;
            font-size: 16px;
            border-radius: 50%;
            padding: 8px 14px;
            transition: all 0.3s ease;
        }

        .custom-pagination .page-link:hover { background: #f2f2f2 !important; }

        .custom-pagination .active .page-link {
            background: #111 !important;
            color: #fff !important;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h4 class="text-white mb-4">
            <i class="fas fa-book-reader"></i> Perpus
        </h4>
        <ul class="nav nav-pills flex-column mb-auto">

            <!-- 1. Dashboard -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>

            <!-- 2. Buku -->
            <li>
                <a href="{{ route('bukus.index') }}"
                   class="nav-link {{ request()->is('bukus*') ? 'active' : '' }}">
                    <i class="fas fa-book me-2"></i> Buku
                </a>
            </li>

            <!-- 3. Buku Items -->
            <li>
                <a href="{{ route('bukuitems.index') }}"
                   class="nav-link {{ request()->is('bukuitems*') ? 'active' : '' }}">
                    <i class="fas fa-book-open me-2"></i> Eksemplar
                </a>
            </li>

            <!-- 4. Kategori -->
            <li>
                <a class="nav-link d-flex justify-content-between align-items-center
                      {{ request()->is('kategoris*') || request()->is('sub_kategoris*') ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#menuKategori" role="button"
                   aria-expanded="{{ request()->is('kategoris*') || request()->is('sub_kategoris*') ? 'true' : 'false' }}"
                   aria-controls="menuKategori">
                    <span><i class="fas fa-tags me-2"></i> Kategori</span>
                    <i class="fas fa-angle-down"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 mt-1 {{ request()->is('kategoris*') || request()->is('sub_kategoris*') ? 'show' : '' }}" id="menuKategori">
                    <li>
                        <a href="{{ route('kategoris.index') }}"
                           class="nav-link {{ request()->is('kategoris*') ? 'active' : '' }}">
                            <i class="fas fa-tag me-2"></i> Kategori
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sub_kategoris.index') }}"
                           class="nav-link {{ request()->is('sub_kategoris*') ? 'active' : '' }}">
                            <i class="fas fa-tags me-2"></i> Sub Kategori
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 5. Rak -->
            <li>
                <a href="{{ route('raks.index') }}"
                   class="nav-link {{ request()->is('raks*') ? 'active' : '' }}">
                    <i class="fas fa-boxes me-2"></i> Rak
                </a>
            </li>

            <!-- 6. Denah -->
            <li>
                <a href="{{ route('lokasis.index') }}"
                   class="nav-link {{ request()->is('lokasis*') ? 'active' : '' }}">
                    <i class="fas fa-map-marker-alt me-2"></i> Denah
                </a>
            </li>

            <!-- 7. Penerbit -->
            <li>
                <a href="{{ route('penerbits.index') }}"
                   class="nav-link {{ request()->is('penerbits*') ? 'active' : '' }}">
                    <i class="fas fa-building me-2"></i> Penerbit
                </a>
            </li>

            <!-- ✅ Khusus Admin & Officer -->
            @if(Auth::check() && in_array(Auth::user()->role, ['Admin','Officer']))
                <li class="mt-3">
                    <hr class="border-secondary">
                </li>
                <li>
                    <a href="{{ route('admin.users') }}"
                       class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog me-2"></i> Kelola Pengguna
                    </a>
                </li>
            @endif

        </ul>
    </div>




    <!-- Content -->
    <div class="flex-grow-1">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                    📚 Perpustakaan Remen Maos
                </a>
                <div class="d-flex">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default.png') }}"
                                     alt="Profile" class="rounded-circle me-2" width="100" height="100">
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i> Akun Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')

<!-- INI AJAX untuk search bar di bukus -->
<script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let q = $(this).val();

            $.getJSON('/bukus/search', { q: q }, function (data) {
                let rows = '';

                if (data.length === 0) {
                    rows = `<tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>`;
                } else {
                    data.forEach(function (b) {
                        rows += `
                        <tr>
                            <td>${b.id}</td>
                            <td>${b.judul}</td>
                            <td>${b.penerbit ?? '-'}</td>
                            <td>
    <a href="/bukus/${b.id}" class="btn btn-info btn-sm">
        <i class="fas fa-eye"></i>
    </a>
    <a href="/bukus/${b.id}/edit" class="btn btn-success btn-sm">
        <i class="fas fa-edit"></i>
    </a>
    <form action="/bukus/${b.id}" method="POST" style="display:inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger btn-sm"
            onclick="return confirm('Yakin hapus data ini?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>

                        </tr>
                    `;
                    });
                }

                $('#buku-list').html(rows);
            });
        });
    });
</script>


<!-- INI AJAX untuk search bar di bukuitems -->
<script>
    $(function () {
        const $input = $('#search-item');
        const $tbody = $('#bukuitem-list');

        if (!$input.length || !$tbody.length) return; // safety

        // simpan isi asli supaya bisa restore saat input kosong
        const originalRows = $tbody.html();

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        let timer = null;
        $input.on('input', function () {
            clearTimeout(timer);
            const q = $(this).val().trim();

            timer = setTimeout(function () {
                if (!q) {
                    $tbody.html(originalRows);
                    return;
                }

                $.getJSON('/bukuitems/search', { q: q })
                    .done(function (data) {
                        if (!data || data.length === 0) {
                            $tbody.html('<tr><td colspan="6" class="text-center text-muted">Tidak ada hasil</td></tr>');
                            return;
                        }

                        let rows = '';
                        data.forEach(function (item) {
                            const judul = escapeHtml(item.judul || '-');
                            const rakNama = item.rak && item.rak.nama ? escapeHtml(item.rak.nama) : '-';
                            const kondisi = escapeHtml(item.kondisi || '-');
                            const status = escapeHtml(item.status || '-');

                            rows += `
                          <tr>
                            <td>${item.id}</td>
                            <td>${judul}</td>
                            <td>${rakNama}</td>
                            <td>${kondisi}</td>
                            <td>${status}</td>
                            <td>
                              <a href="/bukuitems/${item.id}" class="btn btn-info btn-sm" title="Lihat">
                                <i class="fas fa-eye"></i>
                              </a>
                              <a href="/bukuitems/${item.id}/edit" class="btn btn-success btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                              </a>
                              <form action="/bukuitems/${item.id}" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                  <i class="fas fa-trash"></i>
                                </button>
                              </form>
                            </td>
                          </tr>`;
                        });

                        $tbody.html(rows);
                    })
                    .fail(function (xhr) {
                        console.error('bukuitems search error', xhr.status, xhr.responseText);
                        $tbody.html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan. Cek console.</td></tr>');
                    });
            }, 220); // debounce 220ms
        });
    });
</script>



</body>
</html>
