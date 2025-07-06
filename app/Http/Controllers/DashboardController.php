<?php

namespace App\Http\Controllers;

use App\Models\InvoiceKasir;
use App\Models\PenjualanKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tgl1 = '2021-11-01';
        $tgl2 = '2021-12-31';
        $periode = PenjualanKasir::select('tgl')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('tgl')->get();
        // dd($periode);
        $produk = DB::select(DB::raw("SELECT produk_id, produk.nm_produk FROM penjualan_kasir
        LEFT JOIN produk ON penjualan_kasir.produk_id = produk.id
        GROUP BY produk_id"));

        $data_periode = [];

        foreach($periode as $pr){
            $data_periode [] = $pr->tgl;
        }

        $dt_pr = json_encode($data_periode);
       

        // $dt_produk = DB::table('penjualan_kasir')
        //            ->select(DB::raw('SUM(qty) as jml'))
        //            ->where('tgl','2021-12-31')
        //         ->where('produk_id',2)
        //         ->groupBy('produk_id')->first();

        //         dd($dt_produk->jml);
        $data_c = [];
        foreach($produk as $p){
            $dt_chart = [];
            $dt_chart['label']=$p->nm_produk;
            $dt_jml = [];
            foreach($periode as $pr){
               $dt_produk = DB::table('penjualan_kasir')
                   ->select(DB::raw('SUM(qty) as jml'))
                   ->where('tgl',$pr->tgl)
                ->where('produk_id',$p->produk_id)
                ->groupBy('produk_id')->first();
                // $dt_produk = DB::table('penjualan_kasir')
                // ->selectRaw('if(SUM(qty) > 0, SUM(qty), 0) AS jml')
                // ->where('tgl',$pr->tgl)
                // ->where('produk_id',$p->produk_id)
                // ->groupBy('produk_id')
                // ->first();
                $dt_jml[] = (int) ($dt_produk ? $dt_produk->jml : 0);
            }
            $dt_chart['data'] =  $dt_jml;
            $dt_chart['backgroundColor'] = 'yellow';
            $dt_chart['borderColor'] = 'rgb(255, 99, 132)';
            $dt_chart['borderWidth'] = 1;
            $dt_chart['color'] = 'white';
            $data_c [] = $dt_chart;
        }
        // dd(json_encode($data_c));
        $dtc = json_encode($data_c);

        
        // dd($invoice);
    //     $data = [];
 
    //  foreach($invoice as $d) {
    //     $data['label'][] = $row->day_name;
    //     $data['data'][] = (int) $row->count;
    //   }
 
    // $data['chart_data'] = json_encode($data);
        
        return view('page.dashboard',[
            'title' => 'Dashboard',
            'chart' => $dtc,
            'periode' => $dt_pr
            ]);
    }
}
