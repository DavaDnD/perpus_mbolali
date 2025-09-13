<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiRak;

class LokasiRakController extends Controller
{
    public function index() {
        $lokasis = LokasiRak::all();
        return view('lokasis.index', compact('lokasis'));
    }

    public function create() {
        return view('lokasis.create');
    }

    public function store(Request $request) {
        $request->validate(['ruang' => 'required']);
        LokasiRak::create($request->all());
        return redirect()->route('lokasis.index')->with('success','Lokasi berhasil ditambah.');
    }

    public function edit(LokasiRak $lokasi) {
        return view('lokasis.edit', compact('lokasi'));
    }

    public function update(Request $request, LokasiRak $lokasi) {
        $request->validate(['ruang' => 'required']);
        $lokasi->update($request->all());
        return redirect()->route('lokasis.index')->with('success','Lokasi berhasil diperbarui.');
    }

    public function destroy(LokasiRak $lokasi) {
        $lokasi->delete();
        return redirect()->route('lokasis.index')->with('success','Lokasi berhasil dihapus.');
    }
}
