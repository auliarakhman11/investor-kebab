<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\GajiKaryawan;
use App\Models\GajiKaryawanOffice;
use App\Models\Karyawan;
use App\Models\KaryawanOffice;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GajiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Gaji',
        ];
        return view('page.gaji',$data);
    }

    public function listGaji(Request $request)
    {

        $data_user = AksesKota::where('user_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->kota_id;
            
        }

        $dt_gaji = Karyawan::select('karyawan.*')->selectRaw("dt_gapok.jml_gapok, dt_jaga.jml_leader, dt_jaga.jml_rolling, dt_jaga.jml_ms, dt_jaga.jml_masuk, dt_penjualan.jml_penjualan, dt_audit.jml_audit, dt_kasbon.jml_kasbon")
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, IF(role = 1, COUNT(id),0) as jml_leader, IF(role = 2, COUNT(id),0) as jml_rolling, IF(role = 3, COUNT(id),0) as jml_ms, COUNT(id) as jml_masuk FROM jaga_outlet WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_jaga"),
            'karyawan.id','=','dt_jaga.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, SUM(jumlah) as jml_penjualan FROM penjualan_gaji WHERE void = 0 AND tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_penjualan"),
            'karyawan.id','=','dt_penjualan.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, COUNT(id) as jml_audit FROM data_audit WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_audit"),
            'karyawan.id','=','dt_audit.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, SUM(gapok) as jml_gapok FROM gapok WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_gapok"),
            'karyawan.id','=','dt_gapok.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, SUM(jumlah) as jml_kasbon FROM kasbon WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_kasbon"),
            'karyawan.id','=','dt_kasbon.karyawan_id'
        )
        ->where('aktif',1)->whereIn('karyawan.kota_id',$dt_akses)->get();

        return view('component.dt_perhitungan_gaji',[
            'dt_gaji' => $dt_gaji,
            'tgl1' => $request->tgl1,
            'tgl2' => $request->tgl2,
        ])->render();
    }

    public function saveGaji(Request $request)
    {
        $karyawan_id = $request->karyawan_id;
        $kota_id = $request->kota_id;
        $pendapatan = $request->pendapatan;
        $gapok = $request->gapok;
        $persen1 = $request->persen1;
        $persen2 = $request->persen2;
        $gaji_persen = $request->gaji_persen;
        $audit = $request->audit;
        $leader = $request->leader;
        $rolling = $request->rolling;
        $kasbon = $request->kasbon;
        $ms = $request->ms;

        $kd_gabungan = 'GJ'.date('dmy').strtoupper(Str::random(5));

        $gaji_karyawan = [];



        for($count = 0; $count<count($karyawan_id); $count++){
            $gaji_karyawan [] = [
                'kd_gabungan' => $kd_gabungan,
                'karyawan_id' => $karyawan_id[$count],
                'kota_id' => $kota_id[$count],
                'gapok' => $gapok[$count],
                'pendapatan' => $pendapatan[$count],
                'persen1' => $persen1[$count],
                'persen2' => $persen2[$count],
                'gaji_persen' => $gaji_persen[$count],
                'audit' => $audit[$count],
                'leader' => $leader[$count],
                'rolling' => $rolling[$count],
                'kasbon' => $kasbon[$count],
                'ms' => $ms[$count],
                'tgl1' => $request->tgl1,
                'tgl2' => $request->tgl2,
                'user_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        GajiKaryawan::insert($gaji_karyawan);

        return true;
    }

    public function listDataGaji()
    {
        return view('component.list_data_gaji',[
            'dt_gaji' => GajiKaryawan::select('gaji_karyawan.*')->selectRaw("SUM(pendapatan) as ttl_pendapatan, SUM(kasbon) as ttl_kasbon, SUM(gapok) as ttl_gapok, SUM(gaji_persen) as ttl_gaji_persen, kd_gabungan")->groupBy('kd_gabungan')->get(),
        ])->render();
    }

    public function deleteListGaji(Request $request)
    {
        GajiKaryawan::where('kd_gabungan',$request->kd_gabungan)->delete();

        return true;
    }

    public function editListGaji(Request $request)
    {
        return view('component.edit_list_gaji',[
            'dt_gaji' => GajiKaryawan::select('gaji_karyawan.*','karyawan.nama')->join('karyawan','gaji_karyawan.karyawan_id','=','karyawan.id')->where('kd_gabungan',$request->kd_gabungan)->get(),
        ])->render();
    }

    public function printGaji(Request $request)
    {
        $dt_gaji = GajiKaryawan::select('gaji_karyawan.*','karyawan.nama')->join('karyawan','gaji_karyawan.karyawan_id','=','karyawan.id')->where('gaji_karyawan.id',$request->id)->first();
        $name = $dt_gaji->nama.'_'.date("d M Y", strtotime($dt_gaji->tgl1)).'~'.date("d M Y", strtotime($dt_gaji->tgl2));
        $data = [
            'dt_gaji' => $dt_gaji,
            'name' => $name,
        ];
        $pdf = FacadePdf::loadView('page.print_gaji',$data)->setPaper('a4','landscape');

        

        return $pdf->download($name.'.pdf');
    }

    public function listGajiOffice(Request $request)
    {
        $dt_gaji = KaryawanOffice::select("karyawan_office.*")->selectRaw("dt_penjualan.ttl_penjualan, dt_gapok.ttl_gapok, dt_kasbon.jml_kasbon")
        ->leftJoin(
            DB::raw("(SELECT karyawan_office_kota.karyawan_id, SUM(harga_normal * qty) as ttl_penjualan FROM penjualan_kasir LEFT JOIN karyawan_office_kota ON penjualan_kasir.cabang_id = karyawan_office_kota.cabang_id WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' AND void != 2 GROUP BY karyawan_office_kota.karyawan_id) dt_penjualan"),
            'karyawan_office.id','=','dt_penjualan.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, SUM(gapok) as ttl_gapok FROM gapok_office WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id ) dt_gapok"),
            'karyawan_office.id','=','dt_gapok.karyawan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT karyawan_id, SUM(jumlah) as jml_kasbon FROM kasbon_office WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2' GROUP BY karyawan_id) dt_kasbon"),
            'karyawan_office.id','=','dt_kasbon.karyawan_id'
        )
        ->groupBy('karyawan_office.id')
        ->where('karyawan_office.aktif',1)->get();

        return view('component.dt_perhitungan_gaji_office',[
            'dt_gaji' => $dt_gaji,
            'tgl1' => $request->tgl1,
            'tgl2' => $request->tgl2,
        ])->render();
    }

    public function saveGajiOffice(Request $request)
    {
        $karyawan_id = $request->karyawan_id;
        $pendapatan = $request->pendapatan;
        $gapok = $request->gapok;
        $persen = $request->persen;
        $jml_kasbon = $request->jml_kasbon;
        $gaji_persen = $request->gaji_persen;

        $kd_gabungan = 'GJ'.date('dmy').strtoupper(Str::random(5));

        $gaji_karyawan = [];



        for($count = 0; $count<count($karyawan_id); $count++){
            $gaji_karyawan [] = [
                'kd_gabungan' => $kd_gabungan,
                'karyawan_id' => $karyawan_id[$count],
                'gapok' => $gapok[$count],
                'pendapatan' => $pendapatan[$count],
                'persen' => $persen[$count],
                'kasbon' => $jml_kasbon[$count],
                'gaji_persen' => $gaji_persen[$count],
                'tgl1' => $request->tgl1,
                'tgl2' => $request->tgl2,
                'user_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        GajiKaryawanOffice::insert($gaji_karyawan);

        return true;
    }

    public function listDataGajiOffice()
    {
        return view('component.list_data_gaji_office',[
            'dt_gaji' => GajiKaryawanOffice::select('gaji_karyawan_office.*')->selectRaw("SUM(pendapatan) as ttl_pendapatan, SUM(gapok) as ttl_gapok, SUM(gaji_persen) as ttl_gaji_persen, SUM(kasbon) as ttl_kasbon, kd_gabungan")->groupBy('kd_gabungan')->get(),
        ])->render();
    }

    public function deleteListGajiOffice(Request $request)
    {
        GajiKaryawanOffice::where('kd_gabungan',$request->kd_gabungan)->delete();

        return true;
    }

    public function editListGajiOffice(Request $request)
    {
        return view('component.edit_list_gaji_office',[
            'dt_gaji' => GajiKaryawanOffice::select('gaji_karyawan_office.*','karyawan_office.nama')->join('karyawan_office','gaji_karyawan_office.karyawan_id','=','karyawan_office.id')->where('kd_gabungan',$request->kd_gabungan)->get(),
        ])->render();
    }

    public function printGajiOffice(Request $request)
    {
        $dt_gaji = GajiKaryawanOffice::select('gaji_karyawan_office.*','karyawan_office.nama')->join('karyawan_office','gaji_karyawan_office.karyawan_id','=','karyawan_office.id')->where('gaji_karyawan_office.id',$request->id)->first();
        $name = $dt_gaji->nama.'_'.date("d M Y", strtotime($dt_gaji->tgl1)).'~'.date("d M Y", strtotime($dt_gaji->tgl2));
        $data = [
            'dt_gaji' => $dt_gaji,
            'name' => $name,
        ];
        $pdf = FacadePdf::loadView('page.print_gaji_office',$data)->setPaper('a4','landscape');

        

        return $pdf->download($name.'.pdf');
    }

}
