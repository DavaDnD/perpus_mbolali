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
            padding: 16px;
            min-width: 250px;
            z-index: 1000;
            display: none;
            margin-top: 4px;
        }
        .filter-dropdown.show {
            display: block;
        }
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
            <button id="btn-new-user" class="btn btn-m365 d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>New user</span>
            </button>
            <div class="vr"></div>
            <button id="btn-edit-user" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
                <i class="bi bi-pencil"></i>
                <span>Edit</span>
            </button>
            <button id="btn-delete-user" class="btn btn-m365 d-flex align-items-center gap-2" disabled>
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
                <input id="search-user" type="text" class="form-control search-input" placeholder="Search">
            </div>
            <div class="position-relative">
                <button id="btn-filter" class="btn btn-m365 d-flex align-items-center gap-2">
                    <i class="bi bi-funnel"></i>
                    <span>Add filter</span>
                </button>
                <div id="filter-dropdown" class="filter-dropdown">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Filter by Role</label>
                        <select id="filter-role" class="form-select form-select-sm">
                            <option value="">All Roles</option>
                            <option value="Admin">Admin</option>
                            <option value="Officer">Officer</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Filter by Status</label>
                        <select id="filter-status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button id="btn-apply-filter" class="btn btn-primary btn-sm flex-grow-1">Apply</button>
                        <button id="btn-clear-filter" class="btn btn-secondary btn-sm">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Count -->
        <div class="text-secondary small mb-3">
            <span id="user-count">{{ $users->total() }} users found</span>
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
                        <th class="py-3 fw-semibold">Name <i class="bi bi-arrow-down-up small opacity-50"></i></th>
                        <th class="py-3 fw-semibold">Email <i class="bi bi-arrow-down-up small opacity-50"></i></th>
                        <th class="py-3 fw-semibold">Role</th>
                        <th class="py-3 fw-semibold">Status</th>
                    </tr>
                    </thead>
                    <tbody id="user-table-body">
                    @foreach($users as $index => $user)
                        @php
                            $colors = ['primary', 'danger', 'info', 'success', 'warning', 'secondary'];
                            $avatarColor = $colors[$index % count($colors)];
                            $initial = strtoupper(substr($user->name, 0, 1));

                            // Role badge styling
                            $roleBadgeClass = 'bg-light text-dark';
                            if ($user->role === 'Admin') {
                                $roleBadgeClass = 'bg-danger text-white';
                            } elseif ($user->role === 'Officer') {
                                $roleBadgeClass = 'bg-warning text-dark';
                            }

                            // Status online/offline
                            $isOnline = $user->isOnline();
                        @endphp
                        <tr data-id="{{ $user->id }}" class="border-bottom border-m365">
                            <td>
                                <input type="checkbox" class="form-check-input select-user" value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="bg-{{ $avatarColor }} text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-semibold me-2"
                                          style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ $initial }}
                                    </span>
                                    <a href="#" class="text-m365-blue text-decoration-none">{{ $user->name }}</a>
                                </div>
                            </td>
                            <td class="text-secondary">
                                {{ $user->email }}
                                <i class="bi bi-clipboard ms-1 small copy-email" role="button" title="Copy" data-email="{{ $user->email }}"></i>
                            </td>
                            <td>
                                <span class="badge {{ $roleBadgeClass }} border border-m365">{{ $user->role }}</span>
                            </td>
                            <td>
                                <span class="{{ $isOnline ? 'status-online' : 'status-offline' }}"></span>
                                <span class="small">{{ $isOnline ? 'Online' : 'Offline' }}</span>
                            </td>
                        </tr>
                    @endforeach

                    @if($users->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">No users found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="border-top border-m365 p-3 bg-m365-gray">
                <div id="user-pagination" class="d-flex justify-content-between align-items-center">
                    <div class="text-secondary small">
                        Showing {{ $users->firstItem() ?: 0 }} - {{ $users->lastItem() ?: 0 }} of {{ $users->total() }}
                    </div>
                    <div>{!! $users->links() !!}</div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.users.partials.new-user-modal')
    @include('admin.users.partials.edit-user-modal')

@endsection

@push('scripts')
    <script>
        (function(){
            const csrf = "{{ csrf_token() }}";
            const userRole = "{{ auth()->user()->role }}"; // Get current user role
            const $body = document.getElementById('user-table-body');
            const $pagination = document.getElementById('user-pagination');
            const $search = document.getElementById('search-user');
            const $btnEdit = document.getElementById('btn-edit-user');
            const $btnDelete = document.getElementById('btn-delete-user');
            const $btnNew = document.getElementById('btn-new-user');
            const $btnRefresh = document.getElementById('btn-refresh');
            const $btnFilter = document.getElementById('btn-filter');
            const $filterDropdown = document.getElementById('filter-dropdown');
            const $filterRole = document.getElementById('filter-role');
            const $filterStatus = document.getElementById('filter-status');
            const $btnApplyFilter = document.getElementById('btn-apply-filter');
            const $btnClearFilter = document.getElementById('btn-clear-filter');
            const selectAll = document.getElementById('select-all');
            const $userCount = document.getElementById('user-count');
            const $copyNotification = document.getElementById('copy-notification');

            let currentFilters = { role: '', status: '' };

            // Toggle filter dropdown
            $btnFilter.addEventListener('click', () => {
                $filterDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!$btnFilter.contains(e.target) && !$filterDropdown.contains(e.target)) {
                    $filterDropdown.classList.remove('show');
                }
            });

            // Apply filters
            $btnApplyFilter.addEventListener('click', () => {
                currentFilters.role = $filterRole.value;
                currentFilters.status = $filterStatus.value;
                $filterDropdown.classList.remove('show');
                fetchUsers();
            });

            // Clear filters
            $btnClearFilter.addEventListener('click', () => {
                $filterRole.value = '';
                $filterStatus.value = '';
                currentFilters = { role: '', status: '' };
                $filterDropdown.classList.remove('show');
                fetchUsers();
            });

            // Copy email functionality
            function attachCopyHandlers() {
                document.querySelectorAll('.copy-email').forEach(icon => {
                    icon.addEventListener('click', async function() {
                        const email = this.getAttribute('data-email');
                        try {
                            await navigator.clipboard.writeText(email);
                            showCopyNotification();
                        } catch (err) {
                            console.error('Failed to copy:', err);
                        }
                    });
                });
            }

            function showCopyNotification() {
                $copyNotification.classList.add('show');
                setTimeout(() => {
                    $copyNotification.classList.remove('show');
                }, 2000);
            }

            async function updateOnlineStatus() {
                try {
                    const res = await fetch("{{ route('admin.users.onlineStatus') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    // Update status di setiap row
                    document.querySelectorAll('tr[data-id]').forEach(row => {
                        const userId = row.getAttribute('data-id');
                        const statusCell = row.querySelector('td:last-child');
                        if (statusCell && data[userId] !== undefined) {
                            const isOnline = data[userId];
                            const statusDot = statusCell.querySelector('span:first-child');
                            const statusText = statusCell.querySelector('span:last-child');

                            if (statusDot && statusText) {
                                statusDot.className = isOnline ? 'status-online' : 'status-offline';
                                statusText.textContent = isOnline ? 'Online' : 'Offline';
                            }
                        }
                    });
                } catch (err) {
                    console.error('Failed to update online status:', err);
                }
            }

            // Update status setiap 10 detik
            setInterval(updateOnlineStatus, 10000);

            function qs(url, params) {
                const u = new URL(url, location.origin);
                if (params) Object.keys(params).forEach(k => {
                    if (params[k] !== '') u.searchParams.set(k, params[k]);
                });
                return u.toString();
            }

            function renderResponse(data) {
                if (data && typeof data === 'object' && data.rows) {
                    $body.innerHTML = data.rows;
                    $pagination.innerHTML = data.pagination || '';
                    if (data.total !== undefined) {
                        $userCount.textContent = `${data.total} users found`;
                    }
                    attachRowHandlers();
                    attachCopyHandlers();
                    toggleButtons();
                    // Update online status after render
                    setTimeout(updateOnlineStatus, 500);
                } else {
                    $body.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Failed to load</td></tr>';
                }
            }

            async function fetchUsers(url = "{{ route('admin.users') }}", q = null) {
                try {
                    const params = {};
                    if (q === null) q = $search.value.trim();
                    if (q !== '') params.q = q;
                    if (currentFilters.role) params.role = currentFilters.role;
                    if (currentFilters.status) params.status = currentFilters.status;

                    const u = qs(url, params);

                    const res = await fetch(u, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();
                    renderResponse(data);
                } catch (err) {
                    console.error(err);
                    $body.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Error loading</td></tr>';
                }
            }

            function debounce(fn, delay=220){
                let t;
                return (...args)=>{
                    clearTimeout(t);
                    t = setTimeout(()=>fn(...args), delay);
                };
            }

            $search.addEventListener('keyup', debounce(()=> fetchUsers(), 220));

            document.addEventListener('click', function(e){
                const a = e.target.closest('#user-pagination a');
                if (a) {
                    e.preventDefault();
                    fetchUsers(a.href);
                }
            });

            function attachRowHandlers(){
                document.querySelectorAll('.select-user').forEach(ch => {
                    ch.onchange = function(){
                        const row = this.closest('tr');
                        if (this.checked) {
                            row.classList.add('bg-m365-selected');
                        } else {
                            row.classList.remove('bg-m365-selected');
                            selectAll.checked = false;
                        }
                        toggleButtons();
                    };
                });
            }

            function getSelectedIds(){
                return Array.from(document.querySelectorAll('.select-user:checked')).map(i => i.value);
            }

            function toggleButtons(){
                const count = getSelectedIds().length;
                $btnDelete.disabled = (count === 0);
                $btnEdit.disabled = (count !== 1);
            }

            selectAll.addEventListener('change', function(){
                document.querySelectorAll('.select-user').forEach(c=> {
                    c.checked = this.checked;
                    const row = c.closest('tr');
                    if (this.checked) {
                        row.classList.add('bg-m365-selected');
                    } else {
                        row.classList.remove('bg-m365-selected');
                    }
                });
                toggleButtons();
            });

            $btnRefresh.addEventListener('click', ()=> {
                // Clear search and filters, then fetch
                $search.value = '';
                $filterRole.value = '';
                $filterStatus.value = '';
                currentFilters = { role: '', status: '' };
                fetchUsers();
            });

            $btnNew.addEventListener('click', ()=> {
                const modal = new bootstrap.Modal(document.getElementById('modalNewUser'));
                document.getElementById('form-new-user').reset();
                modal.show();
            });

            document.getElementById('form-new-user').addEventListener('submit', async function(e){
                e.preventDefault();
                const form = new FormData(this);
                try {
                    const res = await fetch("{{ route('admin.users.store') }}", {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf },
                        body: form
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        const errors = data.errors ? Object.values(data.errors).flat().join('\n') : data.error || data.message;
                        throw new Error(errors);
                    }
                    bootstrap.Modal.getInstance(document.getElementById('modalNewUser')).hide();
                    fetchUsers();
                    alert(data.message || 'Created');
                } catch (err) {
                    alert(err.message || 'Error creating user');
                }
            });

            $btnEdit.addEventListener('click', async function(){
                const ids = getSelectedIds();
                if (ids.length !== 1) return alert('Select exactly one user');
                try {
                    const res = await fetch("{{ url('admin/users') }}/" + ids[0], {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!res.ok) {
                        throw new Error('Failed to fetch user');
                    }

                    const user = await res.json();
                    document.getElementById('edit-user-id').value = user.id;
                    document.getElementById('edit-name').value = user.name;
                    document.getElementById('edit-email').value = user.email;
                    document.getElementById('edit-role').value = user.role;
                    document.getElementById('edit-password').value = '';
                    document.getElementById('edit-password_confirmation').value = '';

                    // Hide/disable role field for Officer
                    const roleField = document.getElementById('edit-role');
                    const roleContainer = roleField.closest('.mb-2');

                    if (userRole === 'Officer') {
                        roleContainer.style.display = 'none'; // Hide role field for Officer
                    } else {
                        roleContainer.style.display = 'block'; // Show for Admin
                    }

                    new bootstrap.Modal(document.getElementById('modalEditUser')).show();
                } catch (err) {
                    alert('Failed to fetch user: ' + err.message);
                }
            });

            document.getElementById('form-edit-user').addEventListener('submit', async function(e){
                e.preventDefault();
                const id = document.getElementById('edit-user-id').value;
                const formData = new FormData(this);

                // Convert FormData to JSON
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });

                // If Officer, preserve the original role (don't send role change)
                if (userRole === 'Officer') {
                    // Role field is hidden, so we need to get the original value
                    const roleField = document.getElementById('edit-role');
                    data.role = roleField.value; // Use original value
                }

                try {
                    const res = await fetch("{{ url('admin/users') }}/" + id, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    });

                    const responseData = await res.json();

                    if (!res.ok) {
                        const errors = responseData.errors ? Object.values(responseData.errors).flat().join('\n') : responseData.error || responseData.message;
                        throw new Error(errors);
                    }

                    bootstrap.Modal.getInstance(document.getElementById('modalEditUser')).hide();
                    fetchUsers();
                    alert(responseData.message || 'Updated');
                } catch (err) {
                    alert(err.message || 'Update failed');
                }
            });

            $btnDelete.addEventListener('click', async function(){
                const ids = getSelectedIds();
                if (!ids.length) return alert('Select users first');
                if (!confirm(`Delete ${ids.length} users?`)) return;
                try {
                    const res = await fetch("{{ route('admin.users.destroySelected') }}", {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ ids })
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.error || data.message || 'Delete failed');
                    }
                    fetchUsers();
                    alert(data.message || 'Deleted');
                } catch (err) {
                    alert(err.message || 'Delete failed');
                }
            });

            attachRowHandlers();
            attachCopyHandlers();
            toggleButtons();
        })();
    </script>
@endpush
