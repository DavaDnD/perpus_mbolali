<?php

namespace App\Http\Controllers;

use App\Models\BukuItem;
use App\Models\Buku;
use App\Models\Rak;
use Illuminate\Http\Request;

class BukuItemController extends Controller
{
    public function index()
    {
        $bukuitems = BukuItem::with('buku')->paginate(10);
        return view('bukuitems.index', compact('bukuitems'));
    }

    public function create()
    {
        $bukus = Buku::all();
        $raks = Rak::all();

        return view('bukuitems.create', compact('bukus', 'raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'kondisi' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'sumber' => 'required|string|max:50',
            'id_rak' => 'required|exists:raks,id',
        ]);

        BukuItem::create($validated);

        return redirect()->route('bukuitems.index')->with('success', 'Buku Item berhasil ditambahkan.');
    }

    public function edit(BukuItem $bukuitem)
    {
        $bukus = Buku::all();
        $raks = Rak::all();

        return view('bukuitems.edit', compact('bukuitem','bukus','raks')
        );
    }

    public function update(Request $request, BukuItem $bukuitem)
    {
        $validated = $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'kondisi' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'sumber' => 'required|string|max:50',
            'id_rak' => 'required|exists:raks,id',
        ]);

        $bukuitem->update($validated);

        return redirect()->route('bukuitems.index')->with('success', 'Buku Item berhasil diperbarui.');
    }



    public function show($id)
    {
        $bukuitem = BukuItem::with([
            'buku.penerbit',
            'buku.kategori',
            'buku.subKategori',
            // Rak + LokasiRak pakai key yg bener
            'rak' => function ($q) {
                $q->with('lokasiRak', 'kategori');
            }
        ])->findOrFail($id);

        return view('bukuitems.show', compact('bukuitem'));
    }

    public function destroy($id)
    {
        $bukuitem = BukuItem::findOrFail($id);
        $bukuitem->delete();

        return redirect()->route('bukuitems.index')->with('success', 'Eksemplar berhasil dihapus.');
    }


    public function searchByBuku($id)
    {
        $bukuitems = BukuItem::where('id_buku', $id)->paginate(10);
        return view('bukuitems.index', compact('bukuitems'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $bukuitems = \App\Models\BukuItem::with(['buku', 'rak'])
            ->where(function ($query) use ($q) {
                $query->whereHas('buku', function ($qb) use ($q) {
                    $qb->where('judul', 'like', "%{$q}%");
                })
                    ->orWhere('barcode', 'like', "%{$q}%")
                    ->orWhere('kondisi', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhereHas('rak', function ($qr) use ($q) {
                        $qr->where('nama', 'like', "%{$q}%");
                    });
            })
            ->limit(100)
            ->get()
            ->map(function ($it) {
                return [
                    'id'         => $it->id,
                    'judul'      => $it->buku ? $it->buku->judul : null,
                    'rak'        => $it->rak ? ['id' => $it->rak->id, 'nama' => $it->rak->nama] : null,
                    'kondisi'    => $it->kondisi,
                    'status'     => $it->status,
                ];
            });

        return response()->json($bukuitems);
    }



}
