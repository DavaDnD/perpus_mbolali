<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubKategori;
use App\Models\Kategori;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subKategoris = SubKategori::with('kategori')->get();
        return view('sub_kategoris.index', compact('subKategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('sub_kategoris.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_kategori' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
        ]);
        SubKategori::create($request->all());
        return redirect()->route('sub_kategoris.index')->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    public function edit(SubKategori $subKategori)
    {
        $kategoris = Kategori::all();
        return view('sub_kategoris.edit', compact('subKategori', 'kategoris'));
    }

    public function update(Request $request, SubKategori $subKategori)
    {
        $request->validate([
            'sub_kategori' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
        ]);
        $subKategori->update($request->all());
        return redirect()->route('sub_kategoris.index')->with('success', 'Sub Kategori berhasil diperbarui');
    }

    public function destroy(SubKategori $subKategori)
    {
        $subKategori->delete();
        return redirect()->route('sub_kategoris.index')->with('success', 'Sub Kategori berhasil dihapus');
    }
    }
