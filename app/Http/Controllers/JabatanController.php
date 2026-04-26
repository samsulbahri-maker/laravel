<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jabatan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('eselon', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $jabatan = $query->orderBy('kode')->paginate(10)->withQueryString();
        return view('master.jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        $eselonOptions = Jabatan::eselonOptions();

        return view('master.jabatan.create', compact('eselonOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:jabatan,kode',
            'nama' => 'required|string|max:100',
            'eselon' => 'nullable|string|max:10',
            'tunjangan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        $eselonOptions = Jabatan::eselonOptions();

        return view('master.jabatan.edit', compact('jabatan', 'eselonOptions'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:jabatan,kode,' . $jabatan->id,
            'nama' => 'required|string|max:100',
            'eselon' => 'nullable|string|max:10',
            'tunjangan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil diupdate.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
