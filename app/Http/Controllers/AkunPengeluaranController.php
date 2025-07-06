<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\JenisAkunPengeluaran;
use Illuminate\Http\Request;

class AkunPengeluaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Akun Pengeluaran',
            'akun' => AkunPengeluaran::with('jenisAkun')->get(),
            'jenis_akun' => JenisAkunPengeluaran::all(),
        ];
        return view('page.akun_pengeluaran',$data);
    }

    public function addAkun(Request $request)
    {
        AkunPengeluaran::create([
            'nm_akun' => $request->nm_akun,
            'jenis_akun_id' => $request->jenis_akun_id,
        ]);
        return redirect(route('akunPengeluaran'))->with('success','Data berhasil dibuat');
    }

    public function editAkun(Request $request)
    {
        AkunPengeluaran::where('id',$request->id)->update([
            'nm_akun' => $request->nm_akun,
            'jenis_akun_id' => $request->jenis_akun_id,
        ]);
        return redirect(route('akunPengeluaran'))->with('success','Data berhasil diedit');
    }
}
