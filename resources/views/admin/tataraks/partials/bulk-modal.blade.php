<div class="modal fade" id="modalBulkTatarak" tabindex="-1">
    <div class="modal-dialog modal-lg"> <!-- Lebih besar untuk datatable -->
        <form id="form-bulk-tatarak" class="modal-content">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Bulk Penataan</h5></div>
            <div class="modal-body">
                <!-- Step 1: Pilih Judul Buku -->
                <div class="mb-3">
                    <label>Pilih Judul Buku</label>
                    <select id="select-buku" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach(\App\Models\Buku::all() as $buku)
                            <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Step 2: List Eksemplar dengan Datatable -->
                <div id="eksemplar-section" style="display:none;">
                    <h6>Eksemplar Tersedia</h6>
                    <table id="eksemplar-table" class="table table-hover">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-eksemplar"></th>
                            <th>Barcode</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- Range Barcode Input -->
                    <div class="mt-3">
                        <label>Input Range Barcode (misal: 2001-2017)</label>
                        <input id="range-barcode" class="form-control" placeholder="2001-2017">
                        <button type="button" id="btn-apply-range" class="btn btn-secondary mt-2">Apply Range</button>
                    </div>

                </div>

                <!-- Step 3: Pilih Rak & Positions (auto/manual) -->
                <div class="mb-3 mt-3">
                    <label>Rak</label>
                    <select name="id_rak" id="select-rak" class="form-select" required>
                        @foreach(\App\Models\Rak::all() as $rak)
                            <option value="{{ $rak->id }}">{{ $rak->nama }} (Kapasitas: {{ $rak->kapasitas }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="auto-position" checked>
                    <label for="auto-position">Auto Generate Positions (Sequential dari Slot Kosong)</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Submit Bulk</button>
            </div>
        </form>
    </div>
</div>
