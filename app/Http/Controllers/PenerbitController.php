<?php

namespace App\Http\Controllers;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function tampil6()
    {
        $penerbit = Penerbit::orderBy('created_at', 'desc')->paginate(10);
        return view('penerbit.tampil6', compact('penerbit'));
    }


    public function tambah6()
    {
        return view('penerbit.tambah6');
    }

    public function submit5(Request $request)
    {
        $request->validate([
            'kode_penerbit' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $penerbit = new Penerbit();
        $penerbit->kode_penerbit = $request->kode_penerbit;
        $penerbit->name = $request->name;
        $penerbit->save();

        return redirect()->route('penerbit.tampil6');
    }

    public function edit5($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('penerbit.edit5', compact('penerbit'));
    }

    public function update5(Request $request, $id)
    {
        $request->validate([
            'kode_penerbit' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $penerbit = Penerbit::findOrFail($id);
        $penerbit->kode_penerbit = $request->kode_penerbit;
        $penerbit->name = $request->name;
        $penerbit->save();

        return redirect()->route('penerbit.tampil6');
    }

    public function delete5($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->delete();

        return redirect()->route('penerbit.tampil6');
    }
}