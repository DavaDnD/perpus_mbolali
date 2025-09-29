<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-edit-user" class="modal-content">
            @csrf
            <input type="hidden" id="edit-user-id" name="id">
            <div class="modal-header"><h5 class="modal-title">Edit User</h5></div>
            <div class="modal-body">
                <div class="mb-2"><input id="edit-name" name="name" class="form-control" required></div>
                <div class="mb-2"><input id="edit-email" name="email" type="email" class="form-control" required></div>
                <div class="mb-2"><input id="edit-password" name="password" type="password" class="form-control" placeholder="New password (leave blank)"></div>
                <div class="mb-2"><input id="edit-password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm new password"></div>
                <div class="mb-2">
                    <select id="edit-role" name="role" class="form-select" required>
                        <option value="Member">Member</option>
                        <option value="Officer">Officer</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
