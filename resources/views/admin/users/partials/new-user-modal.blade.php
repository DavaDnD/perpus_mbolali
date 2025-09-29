<div class="modal fade" id="modalNewUser" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-new-user" class="modal-content">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Create New User</h5></div>
            <div class="modal-body">
                <div class="mb-2"><input name="name" class="form-control" placeholder="Full name" required></div>
                <div class="mb-2"><input name="email" type="email" class="form-control" placeholder="Email" required></div>
                <div class="mb-2"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
                <div class="mb-2"><input name="password_confirmation" type="password" class="form-control" placeholder="Confirm password" required></div>
                <div class="mb-2">
                    <select name="role" class="form-select" required>
                        <option value="Member">Member</option>
                        <option value="Officer">Officer</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
