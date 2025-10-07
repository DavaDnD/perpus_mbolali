@extends('layouts.app')

@section('content')
    <style>
        /* Minimal custom styles untuk warna yang spesifik Microsoft 365 */
        .bg-m365-gray { background-color: #f5f5f5 !important; } /* Lebih grey untuk table */
        .bg-m365-white { background-color: #ffffff !important; } /* Putih bersih untuk background */
        .border-m365 { border-color: #d1d1d1 !important; } /* Border lebih kontras */
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

        /* Checkbox styling - more bold and contrast */
        .form-check-input {
            border: 2px solid #605e5c !important;
            border-radius: 2px !important;
            width: 18px !important;
            height: 18px !important;
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: #0078d4 !important;
            border-color: #0078d4 !important;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 120, 212, 0.25) !important;
        }
        .form-check-input:hover {
            border-color: #323130 !important;
        }
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
        .status-online {
            width: 10px;
            height: 10px;
            background-color: #92c353;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        .status-offline {
            width: 10px;
            height: 10px;
            background-color: #d1d1d1;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
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
            padding: 15px;
            min-width: 250px;
            z-index: 1000;
            display: none;
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


            <!-- Toolbar -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <button id="btn-new-tatarak" class="btn btn-m365 d-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i>
                    <span>New Penataan</span>
                </button>
            <div class="vr"></div>
                <button id="btn-bulk-tatarak" class="btn btn-m365 d-flex align-items-center gap-2"> <!-- Ini button baru -->
                    <i class="bi bi-box-seam"></i>
                    <span>Bulk Penataan</span>
                </button>
            <button id="btn-edit-tatarak" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-pencil"></i>
                <span>Edit</span>
            </button>
            <button id="btn-delete-tatarak" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-trash"></i>
                <span>Delete</span>
            </button>
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
                <input id="search-tatarak" type="text" class="form-control search-input" placeholder="Search by barcode or user">
            </div>
            <div class="position-relative">
                <button id="btn-filter" class="btn btn-m365 d-flex align-items-center gap-2">
                    <i class="bi bi-funnel"></i>
                    <span>Add filter</span>
                </button>
                <div id="filter-dropdown" class="filter-dropdown">
                    <!-- Form filter: by rak, role user -->
                    <div class="mb-2">
                        <label>Rak</label>
                        <select id="filter-rak" class="form-select">
                            <option value="">All</option>
                            @foreach(\App\Models\Rak::all() as $rak)
                                <option value="{{ $rak->id }}">{{ $rak->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Role User</label>
                        <select id="filter-role" class="form-select">
                            <option value="">All</option>
                            <option value="Admin">Admin</option>
                            <option value="Officer">Officer</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <button id="btn-apply-filter" class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive bg-m365-gray border-m365 rounded">
            <table class="table table-hover mb-0">
                <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all" class="form-check-input"></th>
                    <th>ID</th>
                    <th>Eksemplar Buku</th>
                    <th>Rak</th>
                    <th>Posisi</th>
                    <th>Petugas</th>
                    <th>Modified Date</th>
                </tr>
                </thead>
                <tbody id="tataraks-rows">
                <!-- Rows will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="mt-3"></div>

        <!-- Include Modals -->
        @include('admin.tataraks.partials.new-modal')
        @include('admin.tataraks.partials.edit-modal')
        @include('admin.tataraks.partials.bulk-modal')
    </div>

    @push('scripts')
        <script>
            (() => {
                const $tableBody = document.getElementById('tataraks-rows');
                const $pagination = document.getElementById('pagination');
                const $btnNew = document.getElementById('btn-new-tatarak');
                const $btnBulk = document.getElementById('btn-bulk-tatarak');
                const $btnEdit = document.getElementById('btn-edit-tatarak');
                const $btnDelete = document.getElementById('btn-delete-tatarak');
                const $btnRefresh = document.getElementById('btn-refresh');
                const $searchInput = document.getElementById('search-tatarak');
                const $btnFilter = document.getElementById('btn-filter');
                const $filterDropdown = document.getElementById('filter-dropdown');
                const $btnApplyFilter = document.getElementById('btn-apply-filter');
                const $selectAll = document.getElementById('select-all');
                const csrf = '{{ csrf_token() }}';
                const copyNotification = document.getElementById('copy-notification');
                let currentFilters = {};
                let eksemplarTable = null; // For bulk datatable

                const showCopyNotification = () => {
                    copyNotification.classList.add('show');
                    setTimeout(() => copyNotification.classList.remove('show'), 2000);
                };

                const getSelectedIds = () => Array.from(document.querySelectorAll('.select-tatarak:checked')).map(cb => cb.value);

                const toggleButtons = () => {
                    const selectedCount = getSelectedIds().length;
                    $btnEdit.disabled = selectedCount !== 1;
                    $btnDelete.disabled = selectedCount === 0;
                };

                const attachRowHandlers = () => {
                    document.querySelectorAll('.select-tatarak').forEach(cb => cb.addEventListener('change', toggleButtons));
                };

                const fetchTataraks = async (filters = {}) => {
                    const url = new URL('{{ route('admin.tataraks.index') }}', window.location.origin);
                    Object.entries(filters).forEach(([key, value]) => {
                        if (value) url.searchParams.append(key, value);
                    });
                    try {
                        const res = await fetch(url.toString(), {
                            headers: { 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        $tableBody.innerHTML = data.rows;
                        $pagination.innerHTML = data.pagination;
                        attachRowHandlers();
                        toggleButtons();
                    } catch (err) {
                        alert('Error loading data');
                    }
                };

                // Expose to window for bulk script
                window.fetchTataraks = fetchTataraks;
                window.currentFilters = currentFilters;

                $btnNew.addEventListener('click', () => new bootstrap.Modal(document.getElementById('modalNewTatarak')).show());

                $btnBulk.addEventListener('click', () => {
                    new bootstrap.Modal(document.getElementById('modalBulkTatarak')).show();
                });

                $btnRefresh.addEventListener('click', () => fetchTataraks(currentFilters));

                $searchInput.addEventListener('input', (e) => {
                    currentFilters.q = e.target.value;
                    fetchTataraks(currentFilters);
                });

                $btnFilter.addEventListener('click', () => $filterDropdown.classList.toggle('show'));

                $btnApplyFilter.addEventListener('click', () => {
                    currentFilters.rak = document.getElementById('filter-rak').value;
                    currentFilters.role = document.getElementById('filter-role').value;
                    fetchTataraks(currentFilters);
                    $filterDropdown.classList.remove('show');
                });

                $selectAll.addEventListener('change', (e) => {
                    document.querySelectorAll('.select-tatarak').forEach(cb => cb.checked = e.target.checked);
                    toggleButtons();
                });

                document.getElementById('form-new-tatarak').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    try {
                        const res = await fetch('{{ route('admin.tataraks.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });
                        const response = await res.json();
                        if (!res.ok) {
                            const errors = response.errors ? Object.values(response.errors).flat().join('\n') : response.error || response.message;
                            throw new Error(errors);
                        }
                        bootstrap.Modal.getInstance(document.getElementById('modalNewTatarak')).hide();
                        fetchTataraks(currentFilters);
                        alert(response.message || 'Penataan berhasil dibuat');
                    } catch (err) {
                        alert(err.message || 'Error membuat penataan');
                    }
                });

                $btnEdit.addEventListener('click', async () => {
                    const ids = getSelectedIds();
                    if (ids.length !== 1) return alert('Pilih satu penataan untuk edit');
                    try {
                        const res = await fetch(`{{ url('admin/tataraks') }}/${ids[0]}`);
                        const tatarak = await res.json();
                        document.getElementById('edit-id').value = tatarak.id;
                        document.getElementById('edit-id_buku_item').value = tatarak.id_buku_item;
                        document.getElementById('edit-id_rak').value = tatarak.id_rak;
                        document.getElementById('edit-kolom').value = tatarak.kolom;
                        document.getElementById('edit-baris').value = tatarak.baris;
                        new bootstrap.Modal(document.getElementById('modalEditTatarak')).show();
                    } catch (err) {
                        alert('Error mengambil data penataan');
                    }
                });

                document.getElementById('form-edit-tatarak').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const id = document.getElementById('edit-id').value;
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    try {
                        const res = await fetch(`{{ url('admin/tataraks') }}/${id}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });
                        const response = await res.json();
                        if (!res.ok) {
                            const errors = response.errors ? Object.values(response.errors).flat().join('\n') : response.error || response.message;
                            throw new Error(errors);
                        }
                        bootstrap.Modal.getInstance(document.getElementById('modalEditTatarak')).hide();
                        fetchTataraks(currentFilters);
                        alert(response.message || 'Penataan berhasil diupdate');
                    } catch (err) {
                        alert(err.message || 'Error mengupdate penataan');
                    }
                });

                $btnDelete.addEventListener('click', async function() {
                    const ids = getSelectedIds();
                    if (!ids.length) return alert('Pilih penataan terlebih dahulu');
                    if (!confirm(`Hapus ${ids.length} penataan?`)) return;
                    try {
                        const res = await fetch("{{ route('admin.tataraks.destroySelected') }}", {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ ids })
                        });
                        const data = await res.json();
                        if (!res.ok) {
                            throw new Error(data.error || data.message || 'Hapus gagal');
                        }
                        fetchTataraks(currentFilters);
                        alert(data.message || 'Penataan berhasil dihapus');
                    } catch (err) {
                        alert(err.message || 'Error menghapus penataan');
                    }
                });

                attachRowHandlers();
                toggleButtons();
                fetchTataraks(); // Initial load

            })();

            // ===== BULK TATARAK SCRIPT (jQuery based) =====
            $(document).ready(function() {
                let eksemplarTable = null;

                // Init Select2
                $('#select-buku').select2({
                    placeholder: "-- Cari Judul --",
                    dropdownParent: $('#modalBulkTatarak')
                });

                // Saat pilih judul
                $('#select-buku').on('change', async function() {
                    const idBuku = $(this).val();
                    console.log('Buku ID dipilih:', idBuku);

                    if (!idBuku) {
                        $('#eksemplar-section').hide();
                        return;
                    }

                    try {
                        const url = `{{ url('admin/tataraks/preview') }}/${idBuku}`;
                        console.log('Fetching:', url);

                        const res = await fetch(url);
                        console.log('Response status:', res.status);

                        if (!res.ok) throw new Error(`HTTP ${res.status}`);

                        const items = await res.json();
                        console.log('Data eksemplar:', items);
                        console.log('Jumlah items:', items.length);

                        // Destroy table lama
                        if (eksemplarTable !== null) {
                            eksemplarTable.destroy();
                            eksemplarTable = null;
                        }

                        $('#eksemplar-table tbody').empty();
                        $('#eksemplar-section').show();

                        // Init DataTables
                        eksemplarTable = $('#eksemplar-table').DataTable({
                            data: items,
                            columns: [
                                {
                                    data: null,
                                    orderable: false,
                                    render: function(data, type, row) {
                                        return `<input type="checkbox" class="select-eksemplar form-check-input" data-id="${row.id}">`;
                                    }
                                },
                                { data: 'barcode' },
                                { data: 'kondisi' },
                                { data: 'status' }
                            ],
                            destroy: true,
                            searching: true,
                            paging: true,
                            pageLength: 10,
                            language: {
                                emptyTable: "Tidak ada eksemplar tersedia",
                                zeroRecords: "Tidak ditemukan",
                                search: "Cari:",
                                lengthMenu: "Show _MENU_",
                                info: "Showing _START_ to _END_ of _TOTAL_",
                                paginate: {
                                    first: "First",
                                    last: "Last",
                                    next: "Next",
                                    previous: "Previous"
                                }
                            }
                        });

                        console.log('DataTable initialized successfully');

                    } catch (err) {
                        console.error('Error:', err);
                        alert('Error loading eksemplar: ' + err.message);
                        $('#eksemplar-section').hide();
                    }
                });

                // Select all
                $(document).on('change', '#select-all-eksemplar', function() {
                    $('#eksemplar-table .select-eksemplar').prop('checked', this.checked);
                });

                // Apply range
                $('#btn-apply-range').on('click', function() {
                    const rangeValue = $('#range-barcode').val().trim();
                    if (!rangeValue) return alert('Masukkan range');

                    const parts = rangeValue.split('-');
                    if (parts.length !== 2) return alert('Format: 2001-2017');

                    const start = parseInt(parts[0]);
                    const end = parseInt(parts[1]);

                    if (isNaN(start) || isNaN(end)) return alert('Harus angka!');
                    if (start > end) return alert('Start harus < end');

                    let count = 0;
                    eksemplarTable.rows().every(function() {
                        const barcode = parseInt(this.data().barcode);
                        if (barcode >= start && barcode <= end) {
                            $(this.node()).find('.select-eksemplar').prop('checked', true);
                            count++;
                        }
                    });
                    alert(`${count} eksemplar dipilih`);
                });

                // Submit bulk
                $('#form-bulk-tatarak').on('submit', async function(e) {
                    e.preventDefault();

                    const selectedIds = [];
                    $('#eksemplar-table .select-eksemplar:checked').each(function() {
                        selectedIds.push(parseInt($(this).data('id')));
                    });

                    console.log('Selected IDs:', selectedIds);

                    if (selectedIds.length === 0) return alert('Pilih minimal 1 eksemplar!');

                    const idRak = $('#select-rak').val();
                    if (!idRak) return alert('Pilih rak!');

                    // Generate positions
                    const positions = [];
                    for (let i = 0; i < selectedIds.length; i++) {
                        positions.push({
                            kolom: (i % 5) + 1,
                            baris: Math.floor(i / 5) + 1
                        });
                    }

                    console.log('Sending data:', { selectedIds, idRak, positions });

                    try {
                        const res = await fetch('{{ route('admin.tataraks.bulkStore') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                id_buku_items: selectedIds,
                                id_rak: idRak,
                                positions: positions
                            })
                        });

                        const data = await res.json();
                        console.log('Response:', data);

                        if (!res.ok) throw new Error(data.error || data.message || 'Failed');

                        bootstrap.Modal.getInstance(document.getElementById('modalBulkTatarak')).hide();

                        // Call global function
                        if (typeof window.fetchTataraks === 'function') {
                            window.fetchTataraks(window.currentFilters || {});
                        }

                        alert(data.message || 'Bulk berhasil!');

                        // Reset
                        $('#form-bulk-tatarak')[0].reset();
                        $('#select-buku').val(null).trigger('change');
                        $('#eksemplar-section').hide();

                    } catch (err) {
                        console.error('Submit error:', err);
                        alert(err.message || 'Error bulk insert');
                    }
                });

                // Reset on modal close
                $('#modalBulkTatarak').on('hidden.bs.modal', function() {
                    $('#form-bulk-tatarak')[0].reset();
                    $('#select-buku').val(null).trigger('change');
                    $('#eksemplar-section').hide();
                    if (eksemplarTable !== null) {
                        eksemplarTable.destroy();
                        eksemplarTable = null;
                    }
                });
            });
        </script>


    @endpush
@endsection
