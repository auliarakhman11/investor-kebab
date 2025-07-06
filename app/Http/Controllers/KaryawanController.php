<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Karyawan;
use App\Models\KaryawanOffice;
use App\Models\karyawanOfficeKota;
use App\Models\Kota;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Karyawan',
            'karyawan' => Karyawan::where('aktif',1)->with('kota')->get(),
            'kota' => Kota::all()

        ];
        return view('page.karyawan',$data);
    }

    public function addKaryawan()
    {
        Karyawan::create([
            'nama' => request('nama'),
            'no_tlp' => request('no_tlp'),
            'tgl_masuk' => request('tgl_masuk'),
            'alamat' => request('alamat'),
            'kota_id' => request('kota_id'),
            'gapok' => request('gapok'),
            'aktif' => 1,
        ]);    
        return redirect()->back()->with('success' , 'Data karyawan berhasil dibuat');
    }

    public function editKaryawan(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'tgl_masuk' => $request->tgl_masuk,
            'alamat' => $request->alamat,
            'gapok' => $request->gapok,
            'kota_id' => $request->kota_id,
            
        ];
        Karyawan::where('id',$request->id)->update($data);

        return redirect()->back()->with('success' , 'Data karyawan berhasil diubah');
    }

    public function dropKaryawan(Request $request)
    {
        // Karyawan::find($request->id)->delete();
        Karyawan::where('id',$request->id)->update([
            'aktif' => 0
        ]);
        return redirect()->back()->with('success' , 'Data karyawan berhasil dihapus');
    }

    public function karyawanOffice()
    {
        $data = [
            'title' => 'Karyawan Office',
            'karyawan' => KaryawanOffice::where('aktif',1)->with(['karyawanOfficeKota.cabang'])->get(),
            'cabang' => Cabang::where('off',0)->get(),

        ];
        return view('page.karyawan_office',$data);
    }

    public function addKaryawanOffice(Request $request)
    {
        $cabang_id = $request->cabang_id;
        if($cabang_id){

            $karyawan = KaryawanOffice::create([
                'nama' => $request->nama,
                'no_tlp' => $request->no_tlp,
                'tgl_masuk' => $request->tgl_masuk,
                'gapok' => $request->gapok ? $request->gapok : 0,
                'persen' => $request->persen,
                'alamat' => $request->alamat,
                'aktif' => 1
            ]);

            for($count = 0; $count<count($cabang_id); $count++){
                karyawanOfficeKota::create([
                    'karyawan_id' => $karyawan->id,
                    'cabang_id' => $cabang_id[$count],
                ]);
            }

            return redirect()->back()->with('success' , 'Data karyawan berhasil dihapus');

        }else{
            return redirect()->back()->with('error' , 'Data manager store harus diisi!');
        }

    }

    public function editKaryawanOffice(Request $request)
    {
        $cabang_id = $request->cabang_id;
        if($cabang_id){

            KaryawanOffice::where('id',$request->karyawan_id)->update([
                'nama' => $request->nama,
                'no_tlp' => $request->no_tlp,
                'tgl_masuk' => $request->tgl_masuk,
                'gapok' => $request->gapok ? $request->gapok : 0,
                'persen' => $request->persen,
                'alamat' => $request->alamat,
            ]);

            karyawanOfficeKota::where('karyawan_id',$request->karyawan_id)->delete();

            for($count = 0; $count<count($cabang_id); $count++){
                karyawanOfficeKota::create([
                    'karyawan_id' => $request->karyawan_id,
                    'cabang_id' => $cabang_id[$count],
                ]);
            }

            return redirect()->back()->with('success' , 'Data karyawan berhasil diubah');

        }else{
            return redirect()->back()->with('error' , 'Data manager store harus diisi!');
        }
    }

    public function dropKaryawanOffice(Request $request)
    {
        KaryawanOffice::where('id',$request->id)->update(['aktif' => 0]);
        return redirect()->back()->with('success' , 'Data karyawan dihapus');
    }


}
