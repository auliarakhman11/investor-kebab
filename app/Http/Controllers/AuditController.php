<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\DataAudit;
use App\Models\JagaOutlet;
use App\Models\JenisListAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Audit',
            'tanggal' => JagaOutlet::groupBy('tgl')->orderBy('tgl','DESC')->get(),
        ];
        return view('page.audit',$data);
    }

    public function listJaga(Request $request)
    {
        $data_user = AksesKota::where('user_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->kota_id;
            
        }
        $data = [
            'jaga' => JagaOutlet::select('jaga_outlet.*')->selectRaw("dt_jumlah.jml_audit")
            ->leftJoin(
                DB::raw("(SELECT karyawan_id, COUNT(id) as jml_audit FROM data_audit where tgl = '$request->tanggal' GROUP BY karyawan_id ) dt_jumlah"),
                'jaga_outlet.karyawan_id','=','dt_jumlah.karyawan_id'
            )
            ->leftJoin('karyawan','jaga_outlet.karyawan_id','=','karyawan.id')
            ->where('tgl',$request->tanggal)->whereIn('karyawan.kota_id',$dt_akses)->with(['cabang','karyawan'])->get(),
        ];
        return view('component.dt_jaga',$data)->render();
    }

    public function inputAudit(Request $request)
    {
        $data = [
            'tanggal' => $request->tanggal,
            'karyawan_id' =>$request->karyawan_id,
            'cabang_id' =>$request->cabang_id,
            'buka_toko_id' =>$request->buka_toko_id,
            'jenis_audit' => JenisListAudit::with(['listAudit'])->get(),
            'data_audit' => DataAudit::where('karyawan_id',$request->karyawan_id)->where('tgl',$request->tanggal)->get(),
        ];
        return view('component.input_audit',$data)->render();
    }

    public function addAudit(Request $request)
    {
        DataAudit::where('tgl',$request->tanggal)->where('karyawan_id',$request->karyawan_id)->delete();

        $list_id = $request->list_id;
        if($list_id){
            for($count = 0; $count<count($list_id); $count++){
                DataAudit::create([
                    'buka_toko_id' => $request->buka_toko_id,
                    'cabang_id' => $request->cabang_id,
                    'karyawan_id' => $request->karyawan_id,
                    'list_id' => $list_id[$count],
                    'tgl' => $request->tanggal,
                    'user_id' => Auth::user()->id,
                ]);
            }

        }

        return true;
    }

}
