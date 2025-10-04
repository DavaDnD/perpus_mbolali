@extends('layouts.app')

@section('content')
    <style>
        .bg-m365-gray { background-color: #f5f5f5 !important; }
        .bg-m365-white { background-color: #ffffff !important; }
        .border-m365 { border-color: #d1d1d1 !important; }
        .text-m365-blue { color: #0078d4 !important; }
        .bg-m365-blue { background-color: #0078d4 !important; }
        .bg-m365-selected { background-color: #deecf9 !important; }
        .table-hover tbody tr:hover { background-color: #e8e8e8 !important; }
        .btn-m365 {
            border: none;
            background: transparent;
            color: #323130;
        }
        .btn-m365:hover:not(:disabled) {
            background-color: #e8e8e8 !important;
            color: #323130;
        }
        .btn-m365:disabled { color: #a19f9d; }
        .search-input {
            border: none;
            border-bottom: 2px solid #d1d1d1;
            border-radius: 0;
            padding-left: 32px;
            background-color: #ffffff;
        }
        .search-input:focus {
            border-bottom-color: #0078d4;
            box-shadow: none;
            background-color: #ffffff;
        }
        .badge-status-dipinjam { background: #0078d4; color: white; }
        .badge-status-dikembalikan { background: #107c10; color: white; }
        .badge-status-terlambat { background: #d13438; color: white; }
        .badge-status-hilang { background: #6c757d; color: white; }
        .copy-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #107c10;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            display: none;
            align-items: center;
            gap: 8px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .copy-notification.show {
            display: flex;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        .filter-dropdown {
            position: absolute;
            background: white;
            border: 2px solid #d1d1d1;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px;
            min-width: 250px;
            z-index: 1000;
            display: none;
            margin-top: 4px;
        }
        .filter-dropdown.show { display: block; }
    </style>

    <div class="bg-m365-white min-vh-100 p-4">
        <!-- Copy Notification -->
        <div id="copy-notification" class="copy-notification">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M13.5 4.5L6 12L2.5 8.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Copied!</span>
        </div>

        <!-- Header -->
        <h3 class="mb-3">Transaksi Peminjaman</h3>

        <!-- Toolbar -->
        <div class="d-flex align-items-center gap-2 mb-3">
            <button id="btn-new-loan" class="btn btn-m365 d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>Pinjam Buku</span>
            </button>
            <div class="vr"></div>
            <button id="btn-return" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-arrow-return-left"></i>
                <span>Kembalikan</span>
            </button>
            <button id="btn-extend" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-calendar-plus"></i>
                <span>Perpanjang</span>
            </button>
            <button id="btn-view" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-eye"></i>
                <span>Detail</span>
            </button>
            @if(auth()->user()->role === 'Admin')
                <button id="btn-delete" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                    <i class="bi bi-trash"></i>
                    <span>Hapus</span>
                </button>
            @endif
            <div class="vr"></div>
            <button id="btn-refresh" class="btn btn-m365 d-flex align-items-center gap-2">
                <i class="bi bi-arrow-clockwise"></i>
                <span>Refresh</span>
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="position-relative" style="width: 300px;">
                <i class="bi bi-search position-absolute start-0 top-50 translate-middle-y ms-2 text-secondary"></i>
                <input id="search-input" type="text" class="form-control search-input" placeholder="Cari transaksi, user, atau buku">
            </div>
            <div class="position-relative">
                <button id="btn-filter" class="btn btn-m365 d-flex align-items-center gap-2">
                    <i class="bi bi-funnel"></i>
                    <span>Filter</span>
                </button>
                <div id="filter-dropdown" class="filter-dropdown">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select id="filter-status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif (Dipinjam/Terlambat)</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="dikembalikan">Dikembalikan</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button id="btn-apply-filter" class="btn btn-primary btn-sm flex-grow-1">Terapkan</button>
                        <button id="btn-clear-filter" class="btn btn-secondary btn-sm">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Count -->
        <div class="text-secondary small mb-3">
            <span id="record-count">{{ $tataraks->total() }} transaksi ditemukan</span>
        </div>

        <!-- Table -->
        <div class="bg-m365-gray border border-m365 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-m365-gray border-bottom border-m365">
                    <tr>
                        <th style="width: 50px;" class="py-3">
                            <input type="checkbox" id="select-all" class="form-check-input">
                        </th>
                        <th class="py-3 fw-semibold">Barcode</th>
                        <th class="py-3 fw-semibold">Peminjam</th>
                        <th class="py-3 fw-semibold">Judul Buku</th>
                        <th class="py-3 fw-semibold">Tgl Pinjam</th>
                        <th class="py-3 fw-semibold">Jatuh Tempo</th>
                        <th class="py-3 fw-semibold">Status</th>
                        <th class="py-3 fw-semibold">Sisa Hari</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @include('tataraks.partials.rows')
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="border-top border-m365 p-3 bg-m365-gray">
                <div id="pagination-container">
                    @include('tataraks.partials.pagination')
                </div>
            </div>
        </div>
    </div>

    @include('tataraks.partials.new-loan-modal')
    @include('tataraks.partials.return-modal')
    @include('tataraks.partials.detail-modal')

@endsection

@push('scripts')
    <script src="{{ asset('js/tataraks.js') }}"></script>
@endpush
