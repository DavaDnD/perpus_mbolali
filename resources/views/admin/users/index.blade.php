@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2">
                <button id="btn-new-user" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New User</button>
                <button id="btn-edit-user" class="btn btn-warning" disabled><i class="bi bi-pencil"></i> Edit</button>
                <button id="btn-delete-user" class="btn btn-danger" disabled><i class="bi bi-trash"></i> Delete</button>
                <button id="btn-refresh" class="btn btn-light"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
            </div>

            <div style="min-width:260px;">
                <input id="search-user" class="form-control" placeholder="Search user by name or email...">
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th style="width:48px"><input type="checkbox" id="select-all"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width:140px">Role</th>
                        </tr>
                        </thead>
                        <tbody id="user-table-body">
                        @include('admin.users.partials.rows', ['users' => $users])
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div id="user-pagination">
                    @include('admin.users.partials.pagination', ['users' => $users])
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

            function qs(url, params) {
                const u = new URL(url, location.origin);
                if (params) Object.keys(params).forEach(k => u.searchParams.set(k, params[k]));
                return u.toString();
            }

            function renderResponse(data) {
                if (data && typeof data === 'object' && data.rows) {
                    $body.innerHTML = data.rows;
                    $pagination.innerHTML = data.pagination || '';
                    attachRowHandlers();
                    toggleButtons();
                } else {
                    $body.innerHTML = '<tr><td colspan="4">Failed to load</td></tr>';
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
                    $body.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error loading</td></tr>';
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
                        if (!this.checked) selectAll.checked = false;
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
                document.querySelectorAll('.select-user').forEach(c=> c.checked = this.checked);
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
