<?php


namespace App\Http\Controllers;

use App\Imports\AnggotaImport;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AnggotaController extends Controller
{

    public function tampil1(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('namalengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $anggota = $query->paginate(10)->withQueryString();

        $kelasList = Anggota::where('jenis', 'siswa')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('dataanggota.tampil1', compact('anggota', 'kelasList'));
    }

    public function tambah1()
    {
        $lastNumber = Anggota::pluck('nomor_anggota')
            ->map(fn($nomor) => (int) filter_var($nomor, FILTER_SANITIZE_NUMBER_INT))
            ->max() ?? 0;

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomor_anggota = 'AGT-' . $nextNumber;

        return view('dataanggota.tambah1', compact('nomor_anggota'));
    }

    public function submit1(Request $request)
    {
        $this->validateAnggota($request);

        $lastNumber = Anggota::pluck('nomor_anggota')
            ->map(fn($nomor) => (int) preg_replace('/\D/', '', $nomor))
            ->max() ?? 0;

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorAnggota = 'AGT-' . $nextNumber;

        $data = $request->only(['nis', 'jenis', 'namalengkap', 'alamat', 'no_hp', 'kelas']);
        $data['kelas'] = $data['jenis'] === 'Siswa' ? $data['kelas'] : null;
        $data['nomor_anggota'] = $nomorAnggota;

        Anggota::create($data);

        // Buat akun user otomatis
        User::create([
            'name' => $data['namalengkap'],
            'email' => $data['nis'],
            'password' => Hash::make($data['nis']),
            'role' => 'anggota',
            'nis' => $data['nis'],
        ]);

        return redirect()->route('dataanggota.tampil1')->with('success', 'Anggota dan akun berhasil ditambahkan.');
    }




    public function edit1($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('dataanggota.edit1', compact('anggota'));
    }

    public function update1(Request $request, $id)
    {
        $this->validateAnggota($request, false, $id);

        $data = $request->only(['nis', 'jenis', 'namalengkap', 'nomor_anggota', 'alamat', 'no_hp', 'kelas']);
        $data['kelas'] = $data['jenis'] === 'Siswa' ? $data['kelas'] : null;

        $anggota = Anggota::findOrFail($id);
        $anggota->update($data);

        return redirect()->route('dataanggota.tampil1')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function delete1($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('dataanggota.tampil1')->with('success', 'Anggota berhasil dihapus.');
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        $riwayatPengembalian = $anggota->peminjaman()
            ->with(['buku', 'pengembalian'])
            ->orderByDesc('tanggal_pinjam')
            ->get();

        return view('dataanggota.show1', compact('anggota', 'riwayatPengembalian'));
    }

    public function formUser()
    {
        $userEmail = Auth::user()->email;
        $anggota = Anggota::where('nis', $userEmail)->first();

        if ($anggota) {
            return redirect()->route('user_dashboard.index')->with('info', 'Kamu sudah terdaftar sebagai anggota.');
        }

        return view('user_dashboard.daftaranggota');
    }

    public function simpanUser(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:anggota,nis|unique:users,nis',
            'namalengkap' => 'required|string|max:100',
            'jenis' => 'required|in:Siswa,Guru,Karyawan',
            'kelas' => 'nullable|string|max:10',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        $lastNumber = Anggota::pluck('nomor_anggota')
            ->map(fn($nomor) => (int) preg_replace('/\D/', '', $nomor))
            ->max() ?? 0;

        $nomor_anggota = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Anggota::create([
            'nis' => $request->nis,
            'namalengkap' => $request->namalengkap,
            'jenis' => $request->jenis,
            'kelas' => $request->jenis === 'Siswa' ? $request->kelas : null,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nomor_anggota' => $nomor_anggota,
        ]);

        User::create([
            'name' => $request->namalengkap,
            'email' => $request->nis,
            'password' => Hash::make($request->nis),
            'role' => 'anggota',
        ]);

        return redirect()->route('user_dashboard.index')->with('success', 'Pendaftaran anggota dan akun berhasil!');
    }


    public function daftarSubmit(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:anggota,nis|unique:users,nis',
            'namalengkap' => 'required|string|max:100',
            'jenis' => 'required|in:Siswa,Guru,Karyawan',
            'kelas' => 'nullable|string|max:10',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        // ✅ Tambahkan ini agar nomor_anggota terdefinisi
        $lastNumber = Anggota::pluck('nomor_anggota')
            ->map(function ($nomor) {
                return (int) preg_replace('/\D/', '', $nomor);
            })
            ->max() ?? 0;

        $nomor_anggota = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Simpan anggota
        Anggota::create([
            'nis' => $request->nis,
            'namalengkap' => $request->namalengkap,
            'jenis' => $request->jenis,
            'kelas' => $request->jenis === 'Siswa' ? $request->kelas : null,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nomor_anggota' => $nomor_anggota,
        ]);

        // Simpan user
        User::create([
            'name' => $request->namalengkap,
            'email' => $request->nis,
            'password' => Hash::make($request->nis),
            'role' => 'anggota',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran anggota & akun berhasil!');
    }


    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new AnggotaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data anggota berhasil diimport!');
    }

    private function validateAnggota(Request $request, $isCreate = true, $id = null)
    {
        $uniqueRule = 'unique:anggota,nis';
        if (!$isCreate && $id) {
            $uniqueRule = 'unique:anggota,nis,' . $id;
        }

        $request->validate([
            'nis' => ['required', $uniqueRule],
            'namalengkap' => 'required',
            'jenis' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);
    }
}
