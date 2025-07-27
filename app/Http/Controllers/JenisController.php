<?php

namespace App\Http\Controllers;
use App\Models\Jenis;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function tampil3()
    {
        $jenis = Jenis::orderBy('created_at', 'desc')->paginate(10);
        return view('jenis.tampil3', compact('jenis'));
    }


    public function tambah2()
    {
        return view('jenis.tambah2');
    }

    public function submit2(Request $request)
    {
        $request->validate([
            'kode_jenis' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $jenis = new Jenis();
        $jenis->kode_jenis = $request->kode_jenis;
        $jenis->name = $request->name;
        $jenis->save();

        return redirect()->route('jenis.tampil3');
    }

    public function edit2($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('jenis.edit2', compact('jenis'));
    }

    public function update2(Request $request, $id)
    {
        $request->validate([
            'kode_jenis' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $jenis = Jenis::findOrFail($id);
        $jenis->kode_jenis = $request->kode_jenis;
        $jenis->name = $request->name;
        $jenis->save();

        return redirect()->route('jenis.tampil3');
    }

    public function delete2($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.tampil3');
    }
}
