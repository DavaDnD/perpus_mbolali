<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{


    public function index() {
        $bukus = Buku::with('penerbit')->paginate(10);
        return view('bukus.index', compact('bukus'));
    }

    public function create()
    {
        $penerbits = Penerbit::all();
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();

        return view('bukus.create', compact('penerbits', 'kategoris', 'subKategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'isbn' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:50',
            'id_penerbit' => 'required|exists:penerbits,id',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_sub_kategori' => 'required|exists:sub_kategoris,id',
        ]);

        Buku::create($validated);

        return redirect()->route('bukus.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $penerbits = Penerbit::all();
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();

        return view('bukus.edit', compact('buku', 'penerbits', 'kategoris', 'subKategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'isbn' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:50',
            'id_penerbit' => 'required|exists:penerbits,id',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_sub_kategori' => 'required|exists:sub_kategoris,id',
        ]);

        $buku->update($validated);

        return redirect()->route('bukus.index')->with('success', 'Buku berhasil diperbarui.');
    }
    public function show($id)
    {
        $buku = Buku::with(['penerbit', 'kategori', 'subKategori'])->findOrFail($id);
        return view('bukus.show', compact('buku'));
    }

    public function destroy($id) {
        Buku::findOrFail($id)->delete();
        return redirect()->route('bukus.index')->with('success', 'Buku berhasil dihapus');
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $bukus = Buku::with('penerbit')
            ->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                    ->orWhere('pengarang', 'like', "%{$q}%");
            })
            ->limit(100)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'judul' => $b->judul,
                    'pengarang' => $b->pengarang,
                    'tahun_terbit' => $b->tahun_terbit,
                    'penerbit' => $b->penerbit ? $b->penerbit->nama : '-',
                ];
            });

        return response()->json($bukus);
    }





}
