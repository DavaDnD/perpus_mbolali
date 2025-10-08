<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tatarak;
use App\Models\BukuItem;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TataraksController extends Controller
{
    public function index(Request $request)
    {
        $query = Tatarak::with(['bukuItem.buku', 'rak', 'user']);

        // Search by barcode or user name
        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->whereHas('bukuItem', function ($q) use ($search) {
                $q->where('barcode', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by rak
        if ($request->has('rak') && $request->rak !== '') {
            $query->where('id_rak', $request->rak);
        }

        $tataraks = $query->paginate(15);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rows' => view('admin.tataraks.partials.rows', compact('tataraks'))->render(),
                'pagination' => view('admin.tataraks.partials.pagination', compact('tataraks'))->render(),
                'total' => $tataraks->total()
            ]);
        }

        return view('admin.tataraks.index', compact('tataraks'));
    }

    public function show(Tatarak $tatarak)
    {
        return response()->json($tatarak->load(['bukuItem.buku', 'rak', 'user']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_buku_item' => 'required|exists:buku_items,id',
            'id_rak' => 'required|exists:raks,id',
            'kolom' => 'required|integer|min:1',
            'baris' => 'required|integer|min:1',
        ]);

        $validated['id_user'] = Auth::id();

        $tatarak = Tatarak::create($validated);

        return response()->json(['message' => 'Penataan berhasil dicatat', 'tatarak' => $tatarak]);
    }

    public function update(Request $request, Tatarak $tatarak)
    {
        if (Auth::user()->role === 'Officer' && $tatarak->id_user !== Auth::id()) {
            return response()->json(['error' => 'Anda hanya bisa edit transaksi sendiri'], 403);
        }

        $validated = $request->validate([
            'id_buku_item' => 'required|exists:buku_items,id',
            'id_rak' => 'required|exists:raks,id',
            'kolom' => 'required|integer|min:1',
            'baris' => 'required|integer|min:1',
        ]);

        $tatarak->update($validated);

        return response()->json(['message' => 'Penataan berhasil diperbarui']);
    }

    public function destroy(Tatarak $tatarak)
    {
        if (Auth::user()->role !== 'Admin') {
            return response()->json(['error' => 'Hanya Admin yang bisa hapus transaksi'], 403);
        }

        $tatarak->delete();

        return response()->json(['message' => 'Transaksi dihapus']);
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids) || Auth::user()->role !== 'Admin') {
            return response()->json(['error' => 'Tidak diizinkan atau tidak ada yang dipilih'], 403);
        }

        Tatarak::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Transaksi terpilih dihapus']);
    }

    public function availableItems()
    {
        $tataedIds = Tatarak::pluck('id_buku_item')->toArray();
        $availableItems = BukuItem::with('buku')
            ->whereNotIn('id', $tataedIds)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'barcode' => $item->barcode,
                    'buku_judul' => $item->buku->judul
                ];
            });

        return response()->json($availableItems);
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'id_buku_items' => 'required|array|min:1',
            'id_buku_items.*' => 'required|exists:buku_items,id|unique:tataraks,id_buku_item', // Pastiin belum ditata
            'id_rak' => 'required|exists:raks,id',
            'positions' => 'required|array',
            'positions.*.kolom' => 'required|integer|min:1',
            'positions.*.baris' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $created = [];
        $rak = Rak::find($validated['id_rak']);

        // Cek kapasitas rak global (opsional, tapi recommended)
        if (count($validated['id_buku_items']) > $rak->kapasitas) {
            return response()->json(['error' => 'Jumlah item melebihi kapasitas rak'], 400);
        }

        foreach ($validated['id_buku_items'] as $index => $idBukuItem) {
            $position = $validated['positions'][$index];

            // Cek posisi overflow
            if ($position['kolom'] > $rak->kolom || $position['baris'] > $rak->baris) {
                return response()->json(['error' => "Posisi {$position['kolom']}/{$position['baris']} melebihi ukuran rak"], 400);
            }

            // Cek overlap posisi
            $existing = Tatarak::where('id_rak', $validated['id_rak'])
                ->where('kolom', $position['kolom'])
                ->where('baris', $position['baris'])
                ->exists();
            if ($existing) {
                return response()->json(['error' => "Posisi {$position['kolom']}/{$position['baris']} sudah terisi"], 400);
            }

            $tatarak = Tatarak::create([
                'id_buku_item' => $idBukuItem,
                'id_rak' => $validated['id_rak'],
                'kolom' => $position['kolom'],
                'baris' => $position['baris'],
                'id_user' => $userId,
            ]);
            $created[] = $tatarak;

            // Sync ke BukuItem
            BukuItem::find($idBukuItem)->update(['id_rak' => $validated['id_rak']]);
        }

        return response()->json(['message' => count($created) . ' penataan berhasil dibuat', 'tataraks' => $created]);
    }

    public function preview($idBuku)
    {
        $tataedIds = Tatarak::pluck('id_buku_item')->toArray();
        $items = BukuItem::with('buku')
            ->where('id_buku', $idBuku)
            ->whereNotIn('id', $tataedIds)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'barcode' => $item->barcode,
                    'kondisi' => $item->kondisi,
                    'status' => $item->status,
                ];

            });
        if ($items->isEmpty()) {
            return response()->json([]); // Kosong OK, tapi bisa tambah ['message' => 'Tidak ada eksemplar tersedia']
        }
        return response()->json($items);
    }
}
