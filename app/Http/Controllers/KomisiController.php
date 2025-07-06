<?php

namespace App\Http\Controllers;

use App\Models\Komisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomisiController extends Controller
{
    public function index(Request $request)
    {
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }
        $laporan_komisi = DB::select(DB::raw("SELECT karyawan.nama, SUM(jml_komisi) as jml_komisi FROM `penjualan_karyawan`
        LEFT JOIN karyawan ON penjualan_karyawan.karyawan_id = karyawan.id
        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2'
        GROUP BY karyawan_id"));
        $data = [
            'title' => 'komisi',
            'komisi' => Komisi::get(),
            'laporan_komisi' => $laporan_komisi
        ];
        return view('page.komisi',$data);
    }

    public function addKomisi(Request $request)
    {
        if($request->type == 'persen' && $request->jumlah > 100){
            return redirect()->back()->with('error' , 'Type persentasi maksimal 100%');
        }else{
            $dt_komisi = Komisi::create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'type' => $request->type,
                'jumlah' => $request->jumlah,
                'cek' => $request->cek,
            ]);
            if($request->cek == 'Y'){
                $dt_update = [
                    'cek' => 'T'
                ];
                Komisi::where('id','!=',$dt_komisi->id)->update($dt_update);
            }    
            return redirect()->back()->with('success' , 'Data komisi berhasil dibuat');
        }
        
    }

    public function editKomisi(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'type' => $request->type,
            'jumlah' => $request->jumlah,
            'cek' => $request->cek,
        ];
        Komisi::where('id',$request->id)->update($data);

        if($request->cek == 'Y'){
            $dt_update = [
                'cek' => 'T'
            ];
            Komisi::where('id','!=',$request->id)->update($dt_update);
        }

        return redirect()->back()->with('success' , 'Data komisi berhasil dibuat');
    }
}
