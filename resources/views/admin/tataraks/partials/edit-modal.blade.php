<div class="modal fade" id="modalEditTatarak" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-edit-tatarak" class="modal-content">
            @csrf
            <input type="hidden" id="edit-id" name="id">
            <div class="modal-header"><h5 class="modal-title">Edit Penataan</h5></div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Eksemplar Buku</label>
                    <select id="edit-id_buku_item" name="id_buku_item" class="form-select" required>
                        @foreach(\App\Models\BukuItem::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->barcode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Rak</label>
                    <select id="edit-id_rak" name="id_rak" class="form-select" required>
                        @foreach(\App\Models\Rak::all() as $rak)
                            <option value="{{ $rak->id }}">{{ $rak->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2"><input id="edit-kolom" name="kolom" class="form-control" required type="number" min="1"></div>
                <div class="mb-2"><input id="edit-baris" name="baris" class="form-control" required type="number" min="1"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
