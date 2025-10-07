<div class="modal fade" id="modalNewTatarak" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-new-tatarak" class="modal-content">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Tambah Penataan Baru</h5></div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Eksemplar Buku</label>
                    <select name="id_buku_item" class="form-select" required>
                        @php
                            // Ambil ID eksemplar yang sudah ditata
                            $tataedIds = \App\Models\Tatarak::pluck('id_buku_item')->toArray();
                            // Ambil eksemplar yang belum ditata
                            $availableItems = \App\Models\BukuItem::with('buku')
                                ->whereNotIn('id', $tataedIds)
                                ->get();
                        @endphp
                        @foreach($availableItems as $item)
                            <option value="{{ $item->id }}">{{ $item->buku->judul }} - {{ $item->barcode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Rak</label>
                    <select name="id_rak" class="form-select" required>
                        @foreach(\App\Models\Rak::all() as $rak)
                            <option value="{{ $rak->id }}">{{ $rak->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Petugas</label>
                    <select name="id_user" class="form-select" required>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2"><input name="kolom" class="form-control" placeholder="Kolom" required type="number" min="1"></div>
                <div class="mb-2"><input name="baris" class="form-control" placeholder="Baris" required type="number" min="1"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
