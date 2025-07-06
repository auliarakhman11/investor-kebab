<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\Karyawan;
use App\Models\KaryawanOffice;
use App\Models\Kasbon;
use App\Models\KasbonOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasbonController extends Controller
{
    public function index()
    {
       
        $data = [
            'title' => 'Kasbon',
            'kota' => AksesKota::where('user_id',Auth::user()->id)->with(['kota'])->get(),
            'karyawan' => Karyawan::where('aktif',1)->get(),
        ];
        return view('page.kasbon',$data);
    }

    public function getDataKasbon($kota_id,$tgl1,$tgl2)
    {
        
        $kasbon = Kasbon::selectRaw("kasbon.karyawan_id, SUM(kasbon.jumlah) AS total")->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('kota_id',$kota_id)->groupBy('karyawan_id')->with(['karyawan'])->get();
        
        $data = [
            'kasbon' => $kasbon
        ];

        return view('component.dt_kasbon',$data)->render();

    }

    public function addKasbon(Request $request)
    {
        $dt_karyawan = Karyawan::where('id',$request->karyawan_id)->first();

        Kasbon::create([
            'kota_id' => $dt_karyawan->kota_id,
            'karyawan_id' => $request->karyawan_id,
            'jumlah' => $request->jumlah,
            'tgl' => $request->tgl,
            'admin' => Auth::user()->id,
        ]);

        return true;
    }

    public function getKasbon($karyawan_id,$kota_id,$tgl1,$tgl2)
    {
        $kasbon = Kasbon::where('karyawan_id',$karyawan_id)->where('kota_id',$kota_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->get();

        $data = [
            'kasbon' => $kasbon
        ];

        return view('component.edit_kasbon',$data)->render();
    }

    public function editKasbon(Request $request)
    {
        $id = $request->id;
        $tgl = $request->tgl;
        $jumlah = $request->jumlah;
        for($count = 0; $count<count($id); $count++){
           Kasbon::where('id',$id[$count])->update([
            'tgl' => $tgl[$count],
            'jumlah' => $jumlah[$count],
           ]);
        }

        return true;
    }

    public function dropKasbon($id)
    {
        Kasbon::where('id',$id)->delete();
        return true;
    }


    public function kasbonOffice()
    {
       
        $data = [
            'title' => 'Kasbon',
            // 'kota' => AksesKota::where('user_id',Auth::user()->id)->with(['kota'])->get(),
            'karyawan' => KaryawanOffice::where('aktif',1)->get(),
        ];
        return view('page.kasbon_office',$data);
    }

    public function getDataKasbonOffice($tgl1,$tgl2)
    {
        
        $kasbon = KasbonOffice::selectRaw("kasbon_office.karyawan_id, SUM(kasbon_office.jumlah) AS total")->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('karyawan_id')->with(['karyawanOffice'])->get();
        
        $data = [
            'kasbon' => $kasbon
        ];

        return view('component.dt_kasbon_office',$data)->render();

    }

    public function addKasbonOffice(Request $request)
    {

        KasbonOffice::create([
            'karyawan_id' => $request->karyawan_id,
            'jumlah' => $request->jumlah,
            'tgl' => $request->tgl,
            'admin' => Auth::user()->id,
        ]);

        return true;
    }

    public function getKasbonOffice($karyawan_id,$tgl1,$tgl2)
    {
        $kasbon = KasbonOffice::where('karyawan_id',$karyawan_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->get();

        $data = [
            'kasbon' => $kasbon
        ];

        return view('component.edit_kasbon',$data)->render();
    }

    public function editKasbonOffice(Request $request)
    {
        $id = $request->id;
        $tgl = $request->tgl;
        $jumlah = $request->jumlah;
        for($count = 0; $count<count($id); $count++){
           KasbonOffice::where('id',$id[$count])->update([
            'tgl' => $tgl[$count],
            'jumlah' => $jumlah[$count],
           ]);
        }

        return true;
    }

    public function dropKasbonOffice($id)
    {
        KasbonOffice::where('id',$id)->delete();
        return true;
    }

}
