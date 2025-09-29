@extends('layouts.app')

@section('content')
    <style>
        /* Minimal custom styles untuk warna yang spesifik Microsoft 365 */
        .bg-m365-gray { background-color: #faf9f8 !important; }
        .border-m365 { border-color: #edebe9 !important; }
        .text-m365-blue { color: #0078d4 !important; }
        .bg-m365-blue { background-color: #0078d4 !important; }
        .bg-m365-selected { background-color: #deecf9 !important; }
        .table-hover tbody tr:hover { background-color: #f3f2f1 !important; }
        .btn-m365 {
            border: none;
            background: transparent;
            color: #323130;
        }
        .btn-m365:hover:not(:disabled) {
            background-color: #f3f2f1 !important;
            color: #323130;
        }
        .btn-m365:disabled { color: #a19f9d; }
        .search-input {
            border: none;
            border-bottom: 1px solid #edebe9;
            border-radius: 0;
            padding-left: 32px;
        }
        .search-input:focus {
            border-bottom-color: #0078d4;
            box-shadow: none;
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
    </style>

    <div class="bg-m365-gray min-vh-100 p-4">
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
            <button class="btn btn-m365 d-flex align-items-center gap-2">
                <i class="bi bi-funnel"></i>
                <span>Add filter</span>
            </button>
        </div>

        <!-- Count -->
        <div class="text-secondary small mb-3">
            <span id="user-count">194 users found</span>
        </div>

        <!-- Table -->
        <div class="bg-white border border-m365">
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

                            // Status online/offline (bisa ambil dari database atau logika lain)
                            $isOnline = $user->is_online ?? (rand(0, 1) == 1); // contoh random
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
                                <i class="bi bi-clipboard ms-1 small" role="button" title="Copy"></i>
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
            <div class="border-top border-m365 p-3 bg-white">
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
            const $body = document.getElementById('user-table-body');
            const $pagination = document.getElementById('user-pagination');
            const $search = document.getElementById('search-user');
            const $btnEdit = document.getElementById('btn-edit-user');
            const $btnDelete = document.getElementById('btn-delete-user');
            const $btnNew = document.getElementById('btn-new-user');
            const $btnRefresh = document.getElementById('btn-refresh');
            const selectAll = document.getElementById('select-all');
            const $userCount = document.getElementById('user-count');

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

// Update status setiap 30 detik tanpa reload tabel
            setInterval(updateOnlineStatus, 30000);

            function qs(url, params) {
                const u = new URL(url, location.origin);
                if (params) Object.keys(params).forEach(k => u.searchParams.set(k, params[k]));
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
                    toggleButtons();
                } else {
                    $body.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Failed to load</td></tr>';
                }
            }

            async function fetchUsers(url = "{{ route('admin.users') }}", q = null) {
                try {
                    const params = {};
                    if (q === null) q = $search.value.trim();
                    if (q !== '') params.q = q;
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

            $btnRefresh.addEventListener('click', ()=> fetchUsers());

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
                    if (!res.ok) throw data;
                    bootstrap.Modal.getInstance(document.getElementById('modalNewUser')).hide();
                    fetchUsers();
                    alert(data.message || 'Created');
                } catch (err) {
                    alert(err?.message || 'Error creating user');
                }
            });

            $btnEdit.addEventListener('click', async function(){
                const ids = getSelectedIds();
                if (ids.length !== 1) return alert('Select exactly one user');
                try {
                    const res = await fetch("{{ url('admin/users') }}/" + ids[0]);
                    const user = await res.json();
                    document.getElementById('edit-user-id').value = user.id;
                    document.getElementById('edit-name').value = user.name;
                    document.getElementById('edit-email').value = user.email;
                    document.getElementById('edit-role').value = user.role;
                    document.getElementById('edit-password').value = '';
                    document.getElementById('edit-password_confirmation').value = '';
                    new bootstrap.Modal(document.getElementById('modalEditUser')).show();
                } catch (err) {
                    alert('Failed to fetch user');
                }
            });

            document.getElementById('form-edit-user').addEventListener('submit', async function(e){
                e.preventDefault();
                const id = document.getElementById('edit-user-id').value;
                const form = new FormData(this);
                try {
                    const res = await fetch("{{ url('admin/users') }}/" + id, {
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': csrf },
                        body: form
                    });
                    const data = await res.json();
                    if (!res.ok) throw data;
                    bootstrap.Modal.getInstance(document.getElementById('modalEditUser')).hide();
                    fetchUsers();
                    alert(data.message || 'Updated');
                } catch (err) {
                    alert(err?.error || err?.message || 'Update failed');
                }
            });

            $btnDelete.addEventListener('click', async function(){
                const ids = getSelectedIds();
                if (!ids.length) return alert('Select users first');
                if (!confirm(`Delete ${ids.length} users?`)) return;
                try {
                    const res = await fetch("{{ route('admin.users.destroySelected') }}", {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                        body: JSON.stringify({ ids })
                    });
                    const data = await res.json();
                    if (!res.ok) throw data;
                    fetchUsers();
                    alert(data.message || 'Deleted');
                } catch (err) {
                    alert(err?.error || 'Delete failed');
                }
            });

            attachRowHandlers();
            toggleButtons();
        })();
    </script>
@endpush
