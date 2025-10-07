<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rak;
use App\Models\LokasiRak;
use App\Models\Kategori;

class RakController extends Controller
{
    public function index() {
        $raks = Rak::with(['lokasi','kategori'])->withCount('tataraks')->get();
        return view('raks.index', compact('raks'));
    }

    public function create() {
        $lokasis = LokasiRak::all();
        $kategoris = Kategori::all();
        return view('raks.create', compact('lokasis','kategoris'));
    }

    public function store(Request $request) {
        $request->validate([
            'barcode'=>'required|unique:raks',
            'nama'=>'required',
            'kolom'=>'required|integer',
            'baris'=>'required|integer',
            'kapasitas'=>'required|integer',
            'id_lokasi'=>'required|exists:lokasi_raks,id',
            'id_kategori'=>'required|exists:kategoris,id',
        ]);
        Rak::create($request->all());
        return redirect()->route('raks.index')->with('success','Rak berhasil ditambah.');
    }

    public function edit(Rak $rak) {
        $lokasis = LokasiRak::all();
        $kategoris = Kategori::all();
        return view('raks.edit', compact('rak','lokasis','kategoris'));
    }

    public function update(Request $request, Rak $rak) {
        $request->validate([
            'barcode'=>'required|unique:raks,barcode,'.$rak->id,
            'nama'=>'required',
            'kolom'=>'required|integer',
            'baris'=>'required|integer',
            'kapasitas'=>'required|integer',
            'id_lokasi'=>'required|exists:lokasi_raks,id',
            'id_kategori'=>'required|exists:kategoris,id',
        ]);
        $rak->update($request->all());
        return redirect()->route('raks.index')->with('success','Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak) {
        $rak->delete();
        return redirect()->route('raks.index')->with('success','Rak berhasil dihapus.');
    }
}
