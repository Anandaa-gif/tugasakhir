<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function tampil4()
    {
        $kategori = Kategori::orderBy('created_at', 'desc')->paginate(10);
        return view('kategori.tampil4', compact('kategori'));
    }


    public function tambah3()
    {
        return view('kategori.tambah3');
    }

    public function submit3(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $kategori = new Kategori();
        $kategori->kode_kategori = $request->kode_kategori;
        $kategori->name = $request->name;
        $kategori->save();

        return redirect()->route('kategori.tampil4');
    }

    public function edit3($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit3', compact('kategori'));
    }

    public function update3(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->kode_kategori = $request->kode_kategori;
        $kategori->name = $request->name;
        $kategori->save();

        return redirect()->route('kategori.tampil4');
    }

    public function delete3($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.tampil4');
    }
}