<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbit;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('penerbits.index', compact('penerbits'));
    }

    public function create()
    {
        return view('penerbits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Penerbit::create($request->all());
        return redirect()->route('penerbits.index')->with('success', 'Penerbit berhasil ditambahkan');
    }

    public function edit(Penerbit $penerbit)
    {
        return view('penerbits.edit', compact('penerbit'));
    }

    public function update(Request $request, Penerbit $penerbit)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $penerbit->update($request->all());
        return redirect()->route('penerbits.index')->with('success', 'Penerbit berhasil diperbarui');
    }

    public function destroy(Penerbit $penerbit)
    {
        $penerbit->delete();
        return redirect()->route('penerbits.index')->with('success', 'Penerbit berhasil dihapus');
    }
}
