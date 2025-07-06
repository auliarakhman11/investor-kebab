<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\Bahan;
use App\Models\BarangKebutuhan;
use App\Models\BukaToko;
use App\Models\Cabang;
use App\Models\HargaBahan;
use App\Models\InvoiceKasir;
use App\Models\JagaOutlet;
use App\Models\JenisBahan;
use App\Models\Jurnal;
use App\Models\Karyawan;
use App\Models\Kebutuhan;
use App\Models\PenjualanGaji;
use App\Models\PenjualanKaryawan;
use App\Models\PenjualanKasir;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenjualanKasirController extends Controller
{
    public function perproduk(Request $request)
    {
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }
        $cabang_id = $request->query('outlet');
        if($cabang_id){
            $query_cabang = "AND cabang_id = $cabang_id";
            $dt_cabang = Cabang::where('id',$cabang_id)->first();
        }else{
            $query_cabang = '';
            $dt_cabang = '';
        }

        // $periode = PenjualanKasir::select('tgl')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('tgl')->get();

        $periode = DB::select(DB::raw("SELECT tgl FROM penjualan_kasir
        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND void != 2 $query_cabang
        GROUP BY tgl"));

        $produk = DB::select(DB::raw("SELECT produk_id, produk.nm_produk, SUM(qty) as qty_terjual, SUM((harga_normal * qty)+(total_varian)) AS total_terjual, kategori FROM penjualan_kasir
        LEFT JOIN produk ON penjualan_kasir.produk_id = produk.id
        LEFT JOIN kategori ON produk.kategori_id = kategori.id
        WHERE penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' AND penjualan_kasir.void != 2 $query_cabang
        GROUP BY produk_id"));

        $data_periode = [];

        foreach($periode as $pr){
            $data_periode [] =  date("d-m-Y", strtotime($pr->tgl)) ;
        }

        $dt_pr = json_encode($data_periode);

        $data_c = [];
        foreach($produk as $p){
            $dt_chart = [];
            $dt_chart['label']=$p->nm_produk;
            $dt_jml = [];

            foreach($periode as $pr){
                if($request->query('outlet')){
                    $where_produk = [
                        ['tgl', '=', $pr->tgl],
                        ['produk_id', '=', $p->produk_id],
                        ['void', '!=', 2],
                        ['cabang_id', '=', $cabang_id],
                    ];
                }else{
                    $where_produk = [
                        ['tgl', '=', $pr->tgl],
                        ['produk_id', '=', $p->produk_id],
                        ['void', '!=', 2],
                    ];
                }
                
               $dt_produk = DB::table('penjualan_kasir')
                   ->select(DB::raw('SUM(qty) as jml'))
                   ->where($where_produk)
                ->groupBy('produk_id')->first();

                $dt_jml[] = (int) ($dt_produk ? $dt_produk->jml : 0);
            }

            $rc1 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
            $rc2 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
            $rc3 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);

            $color = $rc1.$rc2.$rc3;

            $dt_chart['data'] =  $dt_jml;
            $dt_chart['backgroundColor'] = '#'.$color;
            $dt_chart['borderColor'] = '#'.$color;
            $dt_chart['borderWidth'] = 1;
            $dt_chart['color'] = 'green';
            $data_c [] = $dt_chart;
        }
        $dtc = json_encode($data_c);

        $data = [
            'title' => 'Perproduk',
            'chart' => $dtc,
            'periode' => $dt_pr,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'produk' => $produk,
            'cabang' => Cabang::all(),
            'dt_cabang' => $dt_cabang,
        ];
        
        return view('page.perproduk',$data);
    }

    public function perhari(Request $request)
    {
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-7 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }


        $cabang_id = $request->query('outlet');
        if($cabang_id){
            $dt_cabang = Cabang::where('id',$cabang_id)->first();
            $query_cabang = "AND cabang_id = $cabang_id";
        }else{
            $query_cabang = '';
            $dt_cabang = '';
        }

        $periode_tgl = PenjualanKasir::select('tgl')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('tgl')->get();

        $perhari = [];
        $dt_periode = [];
        $dt_invoice = [];
        $dt_penjualan = [];
        foreach($periode_tgl as $d){
            $time1 = $d->tgl.' 08:00:00';
            $time2 = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($d->tgl.' 04:00:00')));

            $invoice = InvoiceKasir::selectRaw("COUNT(id) as jml_invoice")->whereRaw("created_at >= '$time1' AND created_at <= '$time2' AND void != 2 $query_cabang")->first();

            $penjualan = PenjualanKasir::selectRaw("SUM(qty) AS jml_penjualan")->whereRaw("created_at >= '$time1' AND created_at <= '$time2' AND void != 2 $query_cabang")->first();

            $dt_periode [] = $d->tgl;
            $dt_penjualan [] = $penjualan->jml_penjualan ? $penjualan->jml_penjualan : 0;
            $dt_invoice [] = $invoice ? $invoice->jml_invoice : 0;

            $kota = DB::table('kota')->select('id')->get();

            foreach($kota as $k){
                $i_penjualan = PenjualanKasir::selectRaw("SUM(qty) AS jml_penjualan, SUM((harga_normal * qty) + total_varian) AS total_penjualan, kota.nm_kota")
                ->leftJoin('cabang','penjualan_kasir.cabang_id','=','cabang.id')
                ->leftJoin('kota','cabang.kota_id','=','kota.id')
                ->whereRaw("penjualan_kasir.created_at >= '$time1' AND penjualan_kasir.created_at <= '$time2' AND void != 2 AND kota.id = $k->id $query_cabang")->first();

                $i_invoice = InvoiceKasir::selectRaw("COUNT(invoice_kasir.id) as jml_invoice")
                ->leftJoin('cabang','invoice_kasir.cabang_id','=','cabang.id')
                ->leftJoin('kota','cabang.kota_id','=','kota.id')
                ->whereRaw("invoice_kasir.created_at >= '$time1' AND invoice_kasir.created_at <= '$time2' AND void != 2 AND kota.id = $k->id $query_cabang")->first();

                $i_komisi = PenjualanKaryawan::selectRaw("SUM(jml_komisi) as jml_komisi")
                ->leftJoin('cabang','penjualan_karyawan.cabang_id','=','cabang.id')
                ->leftJoin('kota','cabang.kota_id','=','kota.id')
                ->whereRaw("penjualan_karyawan.created_at >= '$time1' AND penjualan_karyawan.created_at <= '$time2' AND void != 2 AND kota.id = $k->id $query_cabang $query_cabang")->first();

                if($i_penjualan){
                    array_push($perhari, [
                        'tgl' => $d->tgl,
                        'jml_invoice' => $i_invoice->jml_invoice,
                        'jml_penjualan' => $i_penjualan->jml_penjualan,
                        'nm_kota' => $i_penjualan->nm_kota,
                        'total_penjualan' => $i_penjualan->total_penjualan,
                        'jml_komisi' => $i_komisi->jml_komisi,
                    ]);
                }
                
            }

            
        }      
        $chart_invoice = json_encode($dt_invoice);
        $chart_periode = json_encode($dt_periode);
        $chart_penjualan = json_encode($dt_penjualan);

        $data = [
            'title' => 'Perhari',
            'chart_invoice' => $chart_invoice,
            'chart_periode' => $chart_periode,
            'chart_penjualan' => $chart_penjualan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'perhari' => $perhari,
            'cabang' => Cabang::all(),
            'dt_cabang' => $dt_cabang
        ];
        
        return view('page.perhari',$data);
    }

    public function peroutlet(Request $request)
    {
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }
        $periode = PenjualanKasir::select('tgl')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('tgl')->get();

        $cabang = DB::select(DB::raw("SELECT cabang_id, cabang.nama FROM penjualan_kasir
        LEFT JOIN cabang ON penjualan_kasir.cabang_id = cabang.id
        WHERE penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' AND penjualan_kasir.void != 2
        GROUP BY cabang_id"));

        $peroutlet = DB::select(DB::raw("SELECT cabang.nama, dt_invoice.jml_invoice, dt_penjualan.jml_penjualan, dt_penjualan.total_penjualan, dt_komisi.jml_komisi FROM penjualan_kasir

		LEFT JOIN cabang ON penjualan_kasir.cabang_id = cabang.id

        LEFT JOIN(SELECT cabang_id, COUNT(id) as jml_invoice FROM invoice_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND void != 2 GROUP BY cabang_id) dt_invoice ON penjualan_kasir.cabang_id = dt_invoice.cabang_id
        
        LEFT JOIN (SELECT cabang_id, SUM(qty) AS jml_penjualan, SUM((harga_normal * qty)+(total_varian)) AS total_penjualan  FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND void != 2 GROUP BY cabang_id) dt_penjualan ON penjualan_kasir.cabang_id = dt_penjualan.cabang_id
        
        LEFT JOIN(SELECT cabang_id, SUM(jml_komisi) as jml_komisi FROM penjualan_karyawan WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND void != 2 GROUP BY cabang_id) dt_komisi ON penjualan_kasir.cabang_id = dt_komisi.cabang_id
        
        
        WHERE penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl<= '$tgl2' AND penjualan_kasir.void != 2
        GROUP BY penjualan_kasir.cabang_id"));

        $data_periode = [];

        foreach($periode as $pr){
            $data_periode [] =  date("d-m-Y", strtotime($pr->tgl)) ;
        }

        $dt_pr = json_encode($data_periode);

        $data_c = [];
        foreach($cabang as $p){
            $dt_chart = [];
            $dt_chart['label']=$p->nama;
            $dt_jml = [];
            foreach($periode as $pr){
               $dt_cabang = DB::table('penjualan_kasir')
                   ->select(DB::raw('SUM(qty) as jml'))
                   ->where('tgl',$pr->tgl)
                ->where('cabang_id',$p->cabang_id)
                ->where('void',0)
                ->groupBy('cabang_id')->first();

                $dt_jml[] = (int) ($dt_cabang ? $dt_cabang->jml : 0);
            }

            $rc1 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
            $rc2 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
            $rc3 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);

            $color = $rc1.$rc2.$rc3;

            $dt_chart['data'] =  $dt_jml;
            $dt_chart['backgroundColor'] = '#'.$color;
            $dt_chart['borderColor'] = '#'.$color;
            $dt_chart['borderWidth'] = 1;
            $dt_chart['color'] = 'green';
            $data_c [] = $dt_chart;
        }
        $dtc = json_encode($data_c);

        $data = [
            'title' => 'Peroutlet',
            'chart' => $dtc,
            'periode' => $dt_pr,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'peroutlet' => $peroutlet,
        ];
        
        return view('page.peroutlet',$data);
    }

    public function laporanTransaksi(Request $request)
    {
        // if($request->query('tgl1')){
        //     $tgl1 = $request->query('tgl1');
        //     $tgl2 = $request->query('tgl2');
        // }else{
        //     $tgl1 = date('Y-m-d');
        //     $tgl2 = date('Y-m-d');
        // }

        // $cabang_id = $request->query('outlet');

        // $data_user = AksesKota::where('user_id',Auth::user()->id)->with(['kota.cabang'])->get();
        // $dt_akses = [];
        // foreach($data_user as $da){
        //     foreach($da->kota->cabang as $c){
        //         $dt_akses [] = $c->id;
        //     }
            
        // }
        // $akses_kota = join(",",$dt_akses);
        // if($cabang_id){
        //     $dt_cabang = Cabang::where('id',$cabang_id)->first();
        //     $query_cabang = "AND penjualan_kasir.cabang_id = $cabang_id";

        //     $detail_transaksi = DB::select(DB::raw("SELECT invoice_kasir.*, cabang.nama, dt_penjualan.jml_produk , dt_penjualan.ttl_penjualan, delivery.delivery, pembayaran.pembayaran FROM `invoice_kasir`
        //     LEFT JOIN cabang ON invoice_kasir.cabang_id = cabang.id
        //     LEFT JOIN delivery ON invoice_kasir.delivery_id = delivery.id
        //     LEFT JOIN pembayaran ON invoice_kasir.pembayaran_id = pembayaran.id
        //     LEFT JOIN(SELECT no_invoice, SUM(qty) as jml_produk, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM penjualan_kasir WHERE void != 2 AND penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' AND penjualan_kasir.cabang_id = $cabang_id GROUP BY no_invoice) dt_penjualan ON invoice_kasir.no_invoice = dt_penjualan.no_invoice 
        //     WHERE void != 2 AND invoice_kasir.tgl >= '$tgl1' AND invoice_kasir.tgl <= '$tgl2' AND invoice_kasir.cabang_id = $cabang_id"));

        // }else{
        //     $query_cabang = '';
        //     $dt_cabang = '';

        //     $detail_transaksi = DB::select(DB::raw("SELECT invoice_kasir.*, cabang.nama, dt_penjualan.jml_produk , dt_penjualan.ttl_penjualan, delivery.delivery, pembayaran.pembayaran FROM `invoice_kasir`

        //     LEFT JOIN delivery ON invoice_kasir.delivery_id = delivery.id
        //     LEFT JOIN pembayaran ON invoice_kasir.pembayaran_id = pembayaran.id
        //     LEFT JOIN cabang ON invoice_kasir.cabang_id = cabang.id
        //     LEFT JOIN(SELECT no_invoice, SUM(qty) as jml_produk, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM penjualan_kasir WHERE void != 2 AND penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' GROUP BY no_invoice) dt_penjualan ON invoice_kasir.no_invoice = dt_penjualan.no_invoice 
        //     WHERE void != 2 AND invoice_kasir.tgl >= '$tgl1' AND invoice_kasir.tgl <= '$tgl2'"));
        // }

        // $transaksi = DB::select(DB::raw("SELECT penjualan_kasir.tgl, cabang.nama as cabang, delivery.delivery as delivery, pembayaran.pembayaran as pembayaran, dt_invoice.jml_invoice, SUM(qty) as produk_terjual, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM `penjualan_kasir` 
        // LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
        // LEFT JOIN pembayaran ON penjualan_kasir.pembayaran_id = pembayaran.id
        // LEFT JOIN cabang ON penjualan_kasir.cabang_id = cabang.id
        // LEFT JOIN(SELECT tgl, pembayaran_id, delivery_id, cabang_id, COUNT(id) as jml_invoice FROM invoice_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY delivery_id, pembayaran_id, cabang_id, tgl) dt_invoice ON penjualan_kasir.delivery_id = dt_invoice.delivery_id AND penjualan_kasir.pembayaran_id = dt_invoice.pembayaran_id AND penjualan_kasir.cabang_id = dt_invoice.cabang_id AND penjualan_kasir.tgl = dt_invoice.tgl
        // WHERE penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' $query_cabang AND penjualan_kasir.void != 2
        // GROUP BY penjualan_kasir.delivery_id, penjualan_kasir.pembayaran_id, penjualan_kasir.cabang_id , penjualan_kasir.tgl
        // ORDER BY cabang.nama ASC;"));
        
        // if($cabang_id){
        //     $where_buka = [
        //         ['tgl', '>=', $tgl1],
        //         ['tgl', '<=', $tgl2],
        //         ['cabang_id' , '=', $cabang_id]
        //     ];
        // }else{
        //     $where_buka = [
        //         ['tgl', '>=', $tgl1],
        //         ['tgl', '<=', $tgl2]
        //     ];
        // }
        
        // $dt_detail_buka = DB::select(DB::raw("SELECT cabang.id, cabang.nama, buka.id_buka, buka.tgl_last, buka.jam_buka, buka.jam_tutup, karyawan.nm_karyawan, karyawan.waktu_buka, karyawan.waktu_tutup FROM cabang

        // LEFT JOIN (SELECT MAX(id) as id_buka, cabang_id, MAX(tgl) as tgl_last, MAX(created_at) AS jam_buka, MAX(updated_at) AS jam_tutup FROM buka_toko GROUP BY cabang_id)buka ON cabang.id = buka.cabang_id
        
        // LEFT JOIN (SELECT id as id_buka, nm_karyawan, buka as waktu_buka, tutup as waktu_tutup FROM buka_toko) karyawan ON buka.id_buka = karyawan.id_buka

        // WHERE cabang.id IN (".$akses_kota.")
        //         GROUP by cabang.id"));

        $tanggal = BukaToko::select('tgl')->groupBy('tgl')->orderBy('tgl','DESC')->take(30)->get();
        $data = [
            'title' => 'Transaksi',
            // 'tgl1' => $tgl1,
            // 'tgl2' => $tgl2,
            // 'transaksi' => $transaksi,
            // 'cabang' => Cabang::all(),
            // 'dt_cabang' => $dt_cabang,
            // 'detail_transaksi' => $detail_transaksi,
            // 'buka_toko' => BukaToko::where($where_buka)->with('cabang')->get(),
            // 'dt_detail_buka' => $dt_detail_buka,
            'barang_kebutuhan' => BarangKebutuhan::all(),
            'bahan' => Bahan::all(),
            'tanggal' => $tanggal,
            'akses_kota' => AksesKota::leftJoin('kota','akses_kota.kota_id','=','kota.id')->where('user_id',Auth::user()->id)->get(),
            // 'print' => InvoiceKasir::where('print','>',1)->where('tgl',$tanggal[0]->tgl)->whereIn('cabang_id',$dt_akses)->with(['getPenjualan.produk','getPenjualanKaryawan.karyawan','cabang','delivery','pembayaran'])->get() 
            
        ];

        return view('page.transaksi',$data);
    }

    public function getDataBuka(Request $request)
    {
        $data_user = AksesKota::where('user_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->kota_id;
            
            
        }
        $akses_kota = join(",",$dt_akses);

        

        $dt_detail_buka = DB::select(DB::raw("SELECT buka_toko.kode, cabang.id, cabang.nama, MAX(buka_toko.id) as id_buka, buka_toko.tgl as tgl_last, MAX(buka_toko.created_at) as jam_buka, MAX(buka_toko.updated_at) AS jam_tutup, buka_toko.nm_karyawan, MAX(buka_toko.buka) as waktu_buka, MAX(buka_toko.tutup) AS waktu_tutup, dt_karyawan.nama_karyawan FROM buka_toko

        LEFT JOIN cabang ON buka_toko.cabang_id = cabang.id

        LEFT JOIN (SELECT buka_toko_id, GROUP_CONCAT(DISTINCT karyawan.nama SEPARATOR ',') as nama_karyawan FROM jaga_outlet LEFT JOIN karyawan ON jaga_outlet.karyawan_id = karyawan.id WHERE jaga_outlet.ganti = 0 GROUP BY jaga_outlet.buka_toko_id) dt_karyawan ON buka_toko.id = dt_karyawan.buka_toko_id

        WHERE cabang.kota_id IN (".$akses_kota.") AND buka_toko.tgl = '$request->tanggal3' AND cabang.kota_id = '$request->akses_kota3'
                GROUP by cabang.id
                ORDER BY cabang.possition ASC
                "));

        $data = [
            'dt_detail_buka' => $dt_detail_buka
        ];
        
        return view('component.buka_toko',$data);

    }

    public function getPrint(Request $request)
    {
        $data_user = AksesKota::where('user_id',Auth::user()->id)->where('kota_id',$request->akses_kota2)->with(['kota.cabang'])->get();
        $dt_akses = [];
        foreach($data_user as $da){
            foreach($da->kota->cabang as $c){
                $dt_akses [] = $c->id;
            }
            
        }
        $data = [
            'print' => InvoiceKasir::where('print','>',1)->where('tgl',$request->tanggal2)->whereIn('cabang_id',$dt_akses)->with(['getPenjualan.produk','getPenjualanKaryawan.karyawan','cabang','delivery','pembayaran'])->get()
        ];

        return view('component.dt_print',$data)->render();
    }

    public function getDetailPenjualan(Request $request){
        $tanggal = $request->tanggal;
        $akses_kota = $request->akses_kota;
        $tanggall2    = date('Y-m-d', strtotime('+1 days', strtotime($tanggal)));

        $tgl1    = $tanggal.' 09:00:00';
        $tgl2    = $tanggall2.' 08:59:00';

        $data_user = AksesKota::where('user_id',Auth::user()->id)->where('kota_id',$akses_kota)->with(['kota.cabang'])->get();
        $dt_akses = [];
        foreach($data_user as $da){
            foreach($da->kota->cabang as $c){
                $dt_akses [] = $c->id;
            }
            
        }
        

        $dt_produk = Produk::selectRaw('produk.*, harga.harga as harga_jual')->leftJoin('harga','produk.id','=','harga.produk_id')->leftJoin('penjualan_kasir','penjualan_kasir.produk_id','=','produk.id')->whereIn('penjualan_kasir.cabang_id',$dt_akses)->where('penjualan_kasir.created_at','>=',$tgl1)->where('penjualan_kasir.created_at','<=',$tgl2)->where('harga.delivery_id',1)->groupBy('produk.id')->orderBy('produk.possition','ASC')->get();
        // $dt_minuman = Produk::selectRaw('produk.*, harga.harga as harga_jual')->leftJoin('harga','produk.id','=','harga.produk_id')->where('harga.delivery_id',1)->where('status','ON')->where('kategori_id',4)->get();
        $dt_bahan = Bahan::where('aktif','Y')->orderBy('possition','ASC')->get();
        $dt_barang_kebutuhan = BarangKebutuhan::where('aktif',1)->get();

        // $dt_buka_toko = DB::select(DB::raw("SELECT dt_buka_toko.id_cabang,dt_buka_toko.nm_cabang, dt_buka_toko.id_buka, buka_toko.kode, dt_buka_toko.tgl_buka FROM 
        // (SELECT buka_toko.cabang_id as id_cabang, cabang.nama AS nm_cabang, MAX(buka_toko.id) as id_buka, MAX(buka_toko.tgl) as tgl_buka FROM buka_toko
        // LEFT JOIN cabang ON buka_toko.cabang_id = cabang.id
        // WHERE buka_toko.tgl = '$tanggal'
        // GROUP BY buka_toko.cabang_id
        // ) AS dt_buka_toko
        // LEFT JOIN buka_toko ON dt_buka_toko.id_buka = buka_toko.id
        // WHERE dt_buka_toko.tgl_buka = '$tanggal'"))
        
        $dt_buka_toko = BukaToko::selectRaw("buka_toko.cabang_id as id_cabang, cabang.nama as nm_cabang")->leftJoin('cabang','buka_toko.cabang_id','=','cabang.id')->where('buka_toko.tgl',$tanggal)->whereIn('buka_toko.cabang_id',$dt_akses)->orderBy('cabang.possition','ASC')->groupBy('buka_toko.cabang_id')->get();


        $dt_penjualan_produk = [];
        $dt_penjualan_minuman = [];
        $dt_penjualan_bahan = [];
        $dt_kebutuhan_cabang = [];

        $dt_pembayaran = InvoiceKasir::selectRaw("pembayaran.id as id_pembayaran, pembayaran.pembayaran")->leftJoin('pembayaran','invoice_kasir.pembayaran_id','=','pembayaran.id')->where('invoice_kasir.created_at','>=',$tgl1)->where('invoice_kasir.created_at','<=',$tgl2)->whereIn('invoice_kasir.cabang_id',$dt_akses)->groupBy('pembayaran.id')->get();

        $penjualan = PenjualanKasir::selectRaw("invoice_kasir.cabang_id,SUM(IF(penjualan_kasir.qty,penjualan_kasir.qty,0)) AS terjual, penjualan_kasir.harga_normal, penjualan_kasir.produk_id, invoice_kasir.pembayaran_id as id_pembayaran")->leftJoin('invoice_kasir','penjualan_kasir.no_invoice','=','invoice_kasir.no_invoice')->where('penjualan_kasir.created_at','>=',$tgl1)->where('penjualan_kasir.created_at','<=',$tgl2)->where('invoice_kasir.void','!=',2)->whereIn('penjualan_kasir.cabang_id',$dt_akses)->groupBy('produk_id')->groupBy('invoice_kasir.cabang_id')->groupBy('invoice_kasir.pembayaran_id')->get();
        
        $bahan = Stok::selectRaw("SUM(IF(jenis = 'Masuk', debit, 0)) as total_bawa, SUM(debit) as debit, SUM(kredit) as kredit, bahan_id, cabang_id")->where('stok.created_at','>=',$tgl1)->where('stok.created_at','<=',$tgl2)->whereIn('stok.cabang_id',$dt_akses)->groupBy('stok.cabang_id')->groupBy('bahan_id')->get();
        
        $kebutuhan = Kebutuhan::selectRaw('kebutuhan.*, SUM(qty) as banyak')->groupBy('barang_kebutuhan_id')->groupBy('buka_toko_id')->where('created_at','>=',$tgl1)->where('created_at','<=',$tgl2)->with(['barangKebutuhan','bukaToko'])->get();

        $total_global = [];
        $total_global_minuman = [];

        foreach($dt_pembayaran as $dtp){
            $ttl_qty = 0;
            $ttl_uang = 0;

            $ttl_qty_minuman = 0;
            $ttl_uang_minuman = 0;
            
            foreach($penjualan as $pjn){

                foreach($dt_produk as $dtpr){
                    if($dtpr->kategori_id != 4){
                        if($pjn->produk_id == $dtpr->id && $pjn->id_pembayaran == $dtp->id_pembayaran){
                            $ttl_qty += $pjn->terjual;
                            $ttl_uang += $pjn->terjual * $pjn->harga_normal; 
                        }
                    }else{
                        if($pjn->produk_id == $dtpr->id && $pjn->id_pembayaran == $dtp->id_pembayaran){
                            $ttl_qty_minuman += $pjn->terjual;
                            $ttl_uang_minuman += $pjn->terjual * $pjn->harga_normal; 
                        }
                    }
                    
                }

            }
            

            array_push($total_global, array(
                'pembayaran' => $dtp->pembayaran,
                'ttl_qty' => $ttl_qty,
                'ttl_uang'=>$ttl_uang,
              ));

              array_push($total_global_minuman, array(
                'pembayaran' => $dtp->pembayaran,
                'ttl_qty' => $ttl_qty_minuman,
                'ttl_uang'=>$ttl_uang_minuman,
              ));

        }

        $total_pn = [];
        $total_mn = [];
        $total_br = [];

        foreach($dt_barang_kebutuhan as $dbk){
            $ttl_banyak = 0;
            foreach($kebutuhan as $k){
                if($k->barang_kebutuhan_id == $dbk->id){
                    $ttl_banyak += $k->banyak;
                }
            }
            array_push($total_br, array(
                'ttl_banyak' => $ttl_banyak,
                'barang_kebutuhan_id' => $dbk->id,
              ));
        }

        foreach($dt_produk as $dp){
            if($dp->kategori_id != 4){
                foreach($dt_pembayaran as $dtp){
                    $subtotal = 0;
                    $sub_qty = 0;
                    foreach($penjualan as $pn){
                        
                            if($pn->produk_id == $dp->id && $pn->id_pembayaran ==  $dtp->id_pembayaran){
                                $subtotal += $pn->terjual && $pn->harga_normal ? $pn->terjual * $pn->harga_normal : 0;
                                $sub_qty += $pn->terjual;
                            }
                        
                    }
    
                    array_push($total_pn, array(
                        'subtotal' => $subtotal,
                        'sub_qty'=>$sub_qty,
                        'produk_id' => $dp->id,
                      ));
                }
            }else{
                foreach($dt_pembayaran as $dtp){
                    $subtotal = 0;
                    $sub_qty = 0;
                    foreach($penjualan as $pn){
                        
                            if($pn->produk_id == $dp->id && $pn->id_pembayaran ==  $dtp->id_pembayaran){
                                $subtotal += $pn->terjual && $pn->harga_normal ? $pn->terjual * $pn->harga_normal : 0;
                                $sub_qty += $pn->terjual;
                            }
                        
                    }
    
                    array_push($total_mn, array(
                        'subtotal' => $subtotal,
                        'sub_qty'=>$sub_qty,
                        'produk_id' => $dp->id,
                      ));
                }
            }
            
        }

        $count_pembayaran_minuman = 0;
        $count_pembayaran = 0;
        foreach($dt_buka_toko as $dbt){
            $dt_penjualan = [];
            $data_bahan = [];
            $data_minuman = [];    
            
            $data_kebutuhan = [];

            foreach($dt_barang_kebutuhan as $dbk){
                $nlai = 0;
                foreach($kebutuhan as $k){
                    if($k->barang_kebutuhan_id == $dbk->id && $k->bukaToko->cabang_id == $dbt->id_cabang){
                        array_push($data_kebutuhan, array(
                            'banyak' => $k->banyak,
                            'barang_kebutuhan_id' => $dbk->id,
                        ));
                        $nlai++;
                    }
                }

                if(!$nlai){
                    array_push($data_kebutuhan, array(
                        'banyak' => 0,
                        'barang_kebutuhan_id' => $dbk->id,
                    ));
                }
            }            
            
            
            foreach($dt_produk as $dbh){

                if($dbh->kategori_id !=4){

                    $count_pembayaran = 0;
                    foreach($dt_pembayaran as $dpm){
                        $nlai = 0;
                        foreach($penjualan as $p){
                            if($p->produk_id == $dbh->id && $p->cabang_id == $dbt->id_cabang && $p->id_pembayaran ==  $dpm->id_pembayaran){
                                array_push($dt_penjualan, array(
                                    'kategori_id' => $dbh->kategori_id,
                                    'terjual'=>$p->terjual,
                                    'jml_penjualan' => $p->terjual && $p->harga_normal ? $p->terjual * $p->harga_normal : 0,
                                    'produk_id' => $dbh->id,
                                ));
                                $nlai++;
                            }
                        }
                        $count_pembayaran++;
                        if(!$nlai){
                            array_push($dt_penjualan, array(
                                'kategori_id' => $dbh->kategori_id,
                                'terjual'=>0,
                                'jml_penjualan' => 0,
                                'produk_id' => $dbh->id,
                            ));
                        }
                    }

                }else{

                    $count_pembayaran_minuman = 0;
                    foreach($dt_pembayaran as $dpm){
                        $nlai = 0;
                        foreach($penjualan as $p){
                            if($p->produk_id == $dbh->id && $p->cabang_id == $dbt->id_cabang && $p->id_pembayaran ==  $dpm->id_pembayaran){
                                array_push($data_minuman, array(
                                    'kategori_id' => $dbh->kategori_id,
                                    'terjual'=>$p->terjual,
                                    'jml_penjualan' => $p->terjual && $p->harga_normal ? $p->terjual * $p->harga_normal : 0
                                ));
                                $nlai++;
                            }
                        }
                        $count_pembayaran_minuman++;
                        if(!$nlai){
                            array_push($data_minuman, array(
                                'kategori_id' => $dbh->kategori_id,
                                'terjual'=>0,
                                'jml_penjualan' => 0
                            ));
                        }
                    }

                }                
                
                
            }

            foreach($dt_bahan as $db){
                $nilai_b = 0;
                foreach($bahan as $bh){
                    if($bh->bahan_id == $db->id && $bh->cabang_id == $dbt->id_cabang){
                        array_push($data_bahan, array(
                            'total_bawa'=>$bh->total_bawa,
                            'debit' => $bh->debit,
                            'kredit' => $bh->kredit,
                            'bahan_id' => $db->id,
                          ));
                          $nilai_b++;
                    }
                }

                if(!$nilai_b){
                    array_push($data_bahan, array(
                        'total_bawa'=>0,
                        'debit' => 0,
                        'kredit' => 0,
                        'bahan_id' => $db->id,
                      ));
                }
            }

            

            $nama_outlet = str_replace("Kebab Yasmin ","",$dbt->nm_cabang);
            array_push($dt_penjualan_produk, array(
                'nm_cabang'=>$nama_outlet,
                'penjualan' => $dt_penjualan
              ));

              array_push($dt_penjualan_minuman, array(
                'nm_cabang'=>$nama_outlet,
                'penjualan' => $data_minuman
              ));

              array_push($dt_penjualan_bahan, array(
                'nm_cabang'=>$nama_outlet,
                'stok' => $data_bahan
              ));

              array_push($dt_kebutuhan_cabang, array(
                'nm_cabang'=>$nama_outlet,
                'kebututuhan_cabang' => $data_kebutuhan
              ));


            //   dd($dt_penjualan_produk);
        }

        $total_bahan = [];

            foreach($dt_bahan as $db){
                $ttl_b = 0;
                $ttl_l = 0;
                $ttl_s = 0;
                foreach($bahan as $bh){
                    if($bh->bahan_id == $db->id){
                        $ttl_b += $bh->total_bawa;
                        $ttl_l += ( $bh->total_bawa - ($bh->debit - $bh->kredit) );
                        $ttl_s += ($bh->debit - $bh->kredit);
                    }
                }
                array_push($total_bahan, array(
                    'total_bawa'=>$ttl_b,
                    'laku' => $ttl_l,
                    'sisa' => $ttl_s,
                    'bahan_id' => $db->id,
                  ));
            }

        // dd($dt_penjualan_produk);

        $data = [
            'dt_produk' => $dt_produk,
            // 'dt_minuman' => $dt_minuman,
            'dt_bahan' => $dt_bahan,
            'dt_barang_kebutuhan' => $dt_barang_kebutuhan,
            'dt_penjualan_produk' => $dt_penjualan_produk,
            'dt_penjualan_minuman' => $dt_penjualan_minuman,
            'dt_penjualan_bahan' => $dt_penjualan_bahan,
            'dt_pembayaran' => $dt_pembayaran,
            'dt_kebutuhan_cabang' => $dt_kebutuhan_cabang,
            'count_pembayaran' => $count_pembayaran,
            'count_pembayaran_minuman' => $count_pembayaran_minuman,
            'total_pn' => $total_pn,
            'total_mn' => $total_mn,
            'total_br' => $total_br,
            'total_global' => $total_global,
            'total_global_minuman' => $total_global_minuman,
            'total_bahan' => $total_bahan,
        ];

        return view('component.deatial_penjualan_barang',$data)->render();

    }

    public function getBuka(Request $request)
    {
        $id_buka = $request->query('id_buka');

        $dt_buka = BukaToko::where('id',$id_buka)->first();
        $dt_penjualan = DB::select(DB::raw("SELECT penjualan_kasir.tgl, delivery.delivery as delivery, pembayaran.pembayaran as pembayaran, dt_invoice.jml_invoice, SUM(qty) as produk_terjual, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM `penjualan_kasir` 
        LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
        LEFT JOIN pembayaran ON penjualan_kasir.pembayaran_id = pembayaran.id
        LEFT JOIN(SELECT tgl, pembayaran_id, delivery_id, cabang_id, COUNT(id) as jml_invoice FROM invoice_kasir WHERE tgl = '$dt_buka->tgl' AND invoice_kasir.cabang_id = $dt_buka->cabang_id GROUP BY delivery_id, pembayaran_id) dt_invoice ON penjualan_kasir.delivery_id = dt_invoice.delivery_id AND penjualan_kasir.pembayaran_id = dt_invoice.pembayaran_id 
        WHERE penjualan_kasir.tgl = '$dt_buka->tgl' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2
        GROUP BY penjualan_kasir.delivery_id, penjualan_kasir.pembayaran_id"));

        $produk = DB::select(DB::raw("SELECT produk_id, produk.nm_produk, SUM(qty) as qty_terjual, SUM((harga_normal * qty)+(total_varian)) AS total_terjual, delivery.delivery FROM penjualan_kasir
        LEFT JOIN produk ON penjualan_kasir.produk_id = produk.id
        LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
        WHERE penjualan_kasir.tgl = '$dt_buka->tgl' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2 
        GROUP BY produk_id, delivery_id ORDER BY produk.possition ASC"));

        $dt_stok = DB::select(DB::raw("SELECT bahan.bahan, satuan.satuan, SUM(IF(jenis = 'Masuk',debit,0)) AS stok_masuk, SUM(IF(jenis = 'Keluar',kredit,0)) AS stok_keluar, SUM(IF(jenis = 'Refund',debit,0)) AS stok_refund, SUM(debit-kredit) as sisa_stok 
        FROM stok 
        LEFT JOIN bahan ON stok.bahan_id = bahan.id
        LEFT JOIN satuan ON bahan.satuan_id = satuan.id
        WHERE kode = '$dt_buka->kode' GROUP BY bahan_id ORDER BY bahan.possition ASC"));

       $data = [
           'dt_buka' => $dt_buka,
           'dt_penjualan' => $dt_penjualan,
           'produk' => $produk,
           'dt_stok' => $dt_stok,
           'barang_kebutuhan' => BarangKebutuhan::all(),
           'kebutuhan' => Kebutuhan::where('buka_toko_id',$id_buka)->get()
       ];
       
       return view('component.detail_buka',$data)->render();
    }

    public function getBawaan(Request $request)
    {
        $id_buka = $request->query('id_buka');
        $dt_buka = BukaToko::where('id',$id_buka)->with(['cabang'])->first();

        $dt_stok = DB::select(DB::raw("SELECT bahan.bahan, satuan.satuan, SUM(IF(jenis = 'Masuk',debit,0)) AS stok_masuk, SUM(debit-kredit) as sisa_stok 
        FROM stok 
        LEFT JOIN bahan ON stok.bahan_id = bahan.id
        LEFT JOIN satuan ON bahan.satuan_id = satuan.id
        WHERE kode = '$dt_buka->kode' GROUP BY bahan_id;"));

        $dt_karyawan = JagaOutlet::where('buka_toko_id',$id_buka)->where('ganti',0)->get();

        $data = [
            'dt_buka' => $dt_buka,
            'dt_stok' => $dt_stok,
            'dt_edit' => Stok::where('kode',$dt_buka->kode)->where('jenis','Masuk')->get(),
            'dt_bahan' => Bahan::all(),
            'dt_karyawan' => $dt_karyawan,
            'karyawan' => Karyawan::where('aktif',1)->get(),
        ];

        return view('component.detail_bawaan',$data)->render();

    }

    public function excelLaporanPenjualan()
    {
        $dt_detail_buka = DB::select(DB::raw("SELECT cabang.id, cabang.nama, buka.id_buka, buka.tgl_last, buka.jam_buka, buka.jam_tutup, karyawan.nm_karyawan, karyawan.waktu_buka, karyawan.waktu_tutup FROM cabang

        LEFT JOIN (SELECT MAX(id) as id_buka, cabang_id, MAX(tgl) as tgl_last, MAX(created_at) AS jam_buka, MAX(updated_at) AS jam_tutup FROM buka_toko GROUP BY cabang_id)buka ON cabang.id = buka.cabang_id
        
        LEFT JOIN (SELECT id as id_buka, nm_karyawan, buka as waktu_buka, tutup as waktu_tutup FROM buka_toko) karyawan ON buka.id_buka = karyawan.id_buka

        WHERE buka.jam_buka IS NOT NULL AND buka.jam_tutup IS NOT NULL
                GROUP by cabang.id"));

        $spreadsheet = new Spreadsheet;

        $style = array(
            'font' => array(
                'size' => 12
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $border_collom = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            )
        );
        foreach($dt_detail_buka as $key => $buka){

            $dt_buka = BukaToko::where('id',$buka->id_buka)->first();
            $dt_penjualan = DB::select(DB::raw("SELECT penjualan_kasir.tgl, delivery.delivery as delivery, pembayaran.pembayaran as pembayaran, dt_invoice.jml_invoice, SUM(qty) as produk_terjual, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM `penjualan_kasir` 
            LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
            LEFT JOIN pembayaran ON penjualan_kasir.pembayaran_id = pembayaran.id
            LEFT JOIN(SELECT tgl, pembayaran_id, delivery_id, cabang_id, COUNT(id) as jml_invoice FROM invoice_kasir WHERE created_at >= '$dt_buka->created_at' AND created_at <= '$dt_buka->updated_at' AND invoice_kasir.cabang_id = $dt_buka->cabang_id GROUP BY delivery_id, pembayaran_id) dt_invoice ON penjualan_kasir.delivery_id = dt_invoice.delivery_id AND penjualan_kasir.pembayaran_id = dt_invoice.pembayaran_id 
            WHERE penjualan_kasir.created_at >= '$dt_buka->created_at' AND penjualan_kasir.created_at <= '$dt_buka->updated_at' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2
            GROUP BY penjualan_kasir.delivery_id, penjualan_kasir.pembayaran_id"));

            $produk = DB::select(DB::raw("SELECT produk_id, produk.nm_produk, SUM(qty) as qty_terjual, SUM((harga_normal * qty)+(total_varian)) AS total_terjual, delivery.delivery FROM penjualan_kasir
            LEFT JOIN produk ON penjualan_kasir.produk_id = produk.id
            LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
            WHERE penjualan_kasir.created_at >= '$dt_buka->created_at' AND penjualan_kasir.created_at <= '$dt_buka->updated_at' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2 
            GROUP BY produk_id, delivery_id"));

            $dt_stok = DB::select(DB::raw("SELECT bahan.bahan, satuan.satuan, SUM(IF(jenis = 'Masuk',debit,0)) AS stok_masuk, SUM(debit-kredit) as sisa_stok 
            FROM stok 
            LEFT JOIN bahan ON stok.bahan_id = bahan.id
            LEFT JOIN satuan ON bahan.satuan_id = satuan.id
            WHERE kode = '$dt_buka->kode' GROUP BY bahan_id;"));
            
            if($key > 0){
                $spreadsheet->createSheet();
            }
            $nama_outlet = str_replace("Kebab Yasmin ","",$buka->nama);
            $spreadsheet->setActiveSheetIndex($key);
            $spreadsheet->getActiveSheet()->setTitle($nama_outlet);
            $spreadsheet->getActiveSheet()->setCellValue('A1', $buka->nama);
            $spreadsheet->getActiveSheet()->setCellValue('A2', $buka->nm_karyawan);
            $spreadsheet->getActiveSheet()->setCellValue('A3', 'Buka dari '.date("d M Y H:i", strtotime($dt_buka->created_at)));
            $spreadsheet->getActiveSheet()->setCellValue('A4', 'Sampai '.date("d M Y H:i", strtotime($dt_buka->updated_at)));

            $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:C2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:C3');
            $spreadsheet->getActiveSheet()->mergeCells('A4:C4');

            

            //laporan total
            $spreadsheet->getActiveSheet()->setCellValue('A6', 'Laporan Total');
            $spreadsheet->getActiveSheet()->mergeCells('A6:E6');
            $spreadsheet->getActiveSheet()->setCellValue('A7', 'Jenis Order');
            $spreadsheet->getActiveSheet()->setCellValue('B7', 'Jenis Pembayaran');
            $spreadsheet->getActiveSheet()->setCellValue('C7', 'Jumlah Transaksi');
            $spreadsheet->getActiveSheet()->setCellValue('D7', 'Produk Terjual');
            $spreadsheet->getActiveSheet()->setCellValue('E7', 'Total Penjualan');

            $spreadsheet->getActiveSheet()->getStyle('A6:E7')->applyFromArray($style);


            $spreadsheet->getActiveSheet()->getStyle('A6:E7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            $total_penjualan = 0;
            foreach ($dt_penjualan as $p) {
                $total_penjualan += $p->ttl_penjualan;
                $spreadsheet->setActiveSheetIndex($key);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, $p->delivery);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $kolom, $p->pembayaran);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $kolom, number_format($p->jml_invoice,0));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $kolom, number_format($p->produk_terjual,0));
                $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, number_format($p->ttl_penjualan,0));               
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, 'Total');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, number_format($total_penjualan,0));

            $spreadsheet->getActiveSheet()->mergeCells('A'.$kolom.':D'.$kolom);

            $spreadsheet->getActiveSheet()->getStyle('A6:E' . $kolom)->applyFromArray($border_collom);
            //end laporan total

            //detai perproduk
            $spreadsheet->getActiveSheet()->setCellValue('G6', 'Detail Perproduk');
            $spreadsheet->getActiveSheet()->mergeCells('G6:J6');
            $spreadsheet->getActiveSheet()->setCellValue('G7', 'Produk');
            $spreadsheet->getActiveSheet()->setCellValue('H7', 'Order');
            $spreadsheet->getActiveSheet()->setCellValue('I7', 'Terjual');
            $spreadsheet->getActiveSheet()->setCellValue('J7', 'Total');

            $spreadsheet->getActiveSheet()->getStyle('G6:J7')->applyFromArray($style);

            $spreadsheet->getActiveSheet()->getStyle('G6:J7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            $total_produk = 0;
            foreach ($produk as $p) {
                $total_produk += $p->total_terjual;
                $spreadsheet->setActiveSheetIndex($key);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, $p->nm_produk);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $kolom, $p->delivery);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $kolom, $p->qty_terjual);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, number_format($p->total_terjual,0));            
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, 'Total');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, number_format($total_produk,0));

            $spreadsheet->getActiveSheet()->mergeCells('G'.$kolom.':I'.$kolom);

            $spreadsheet->getActiveSheet()->getStyle('G6:J' . $kolom)->applyFromArray($border_collom);
            //end detail perproduk

            //laporan stok bawaan
            $spreadsheet->getActiveSheet()->setCellValue('L6', 'Laporan Stok Bawaan');
            $spreadsheet->getActiveSheet()->mergeCells('L6:N6');
            $spreadsheet->getActiveSheet()->setCellValue('L7', 'Barang');
            $spreadsheet->getActiveSheet()->setCellValue('M7', 'Stok Awal');
            $spreadsheet->getActiveSheet()->setCellValue('N7', 'Stok Sisa');

            $spreadsheet->getActiveSheet()->getStyle('L6:N7')->applyFromArray($style);
            
            $spreadsheet->getActiveSheet()->getStyle('L6:N7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            foreach ($dt_stok as $d) {
                $spreadsheet->setActiveSheetIndex($key);
                $spreadsheet->getActiveSheet()->setCellValue('L' . $kolom, $d->bahan);
                $spreadsheet->getActiveSheet()->setCellValue('M' . $kolom, $d->stok_masuk.' '.$d->satuan);
                $spreadsheet->getActiveSheet()->setCellValue('N' . $kolom, $d->sisa_stok.' '.$d->satuan);         
                $kolom++;
            }

            $batas = $kolom-1;
            $spreadsheet->getActiveSheet()->getStyle('L6:N' . $batas)->applyFromArray($border_collom);
            //end Lapora Stok Bawaan

            foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
                $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Lapora Penjualan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excelLaporanPenjualanPeroutlet(Request $request)
    {
        $spreadsheet = new Spreadsheet;

        $style = array(
            'font' => array(
                'size' => 12
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $border_collom = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            )
        );

            $dt_buka = BukaToko::where('id',$request->query('id_buka'))->with('cabang')->first();
            $dt_penjualan = DB::select(DB::raw("SELECT penjualan_kasir.tgl, delivery.delivery as delivery, pembayaran.pembayaran as pembayaran, dt_invoice.jml_invoice, SUM(qty) as produk_terjual, SUM((qty * harga_normal) + total_varian) as ttl_penjualan FROM `penjualan_kasir` 
            LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
            LEFT JOIN pembayaran ON penjualan_kasir.pembayaran_id = pembayaran.id
            LEFT JOIN(SELECT tgl, pembayaran_id, delivery_id, cabang_id, COUNT(id) as jml_invoice FROM invoice_kasir WHERE created_at >= '$dt_buka->created_at' AND created_at <= '$dt_buka->updated_at' AND invoice_kasir.cabang_id = $dt_buka->cabang_id GROUP BY delivery_id, pembayaran_id) dt_invoice ON penjualan_kasir.delivery_id = dt_invoice.delivery_id AND penjualan_kasir.pembayaran_id = dt_invoice.pembayaran_id 
            WHERE penjualan_kasir.created_at >= '$dt_buka->created_at' AND penjualan_kasir.created_at <= '$dt_buka->updated_at' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2
            GROUP BY penjualan_kasir.delivery_id, penjualan_kasir.pembayaran_id"));

            $produk = DB::select(DB::raw("SELECT produk_id, produk.nm_produk, SUM(qty) as qty_terjual, SUM((harga_normal * qty)+(total_varian)) AS total_terjual, delivery.delivery FROM penjualan_kasir
            LEFT JOIN produk ON penjualan_kasir.produk_id = produk.id
            LEFT JOIN delivery ON penjualan_kasir.delivery_id = delivery.id
            WHERE penjualan_kasir.created_at >= '$dt_buka->created_at' AND penjualan_kasir.created_at <= '$dt_buka->updated_at' AND penjualan_kasir.cabang_id = $dt_buka->cabang_id AND penjualan_kasir.void != 2 
            GROUP BY produk_id, delivery_id"));

            $dt_stok = DB::select(DB::raw("SELECT bahan.bahan, satuan.satuan, SUM(IF(jenis = 'Masuk',debit,0)) AS stok_masuk, SUM(debit-kredit) as sisa_stok 
            FROM stok 
            LEFT JOIN bahan ON stok.bahan_id = bahan.id
            LEFT JOIN satuan ON bahan.satuan_id = satuan.id
            WHERE kode = '$dt_buka->kode' GROUP BY bahan_id;"));
            
            $nama_outlet = str_replace("Kebab Yasmin ","",$dt_buka->cabang->nama);
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle($nama_outlet);
            $spreadsheet->getActiveSheet()->setCellValue('A1', $dt_buka->cabang->nama);
            $spreadsheet->getActiveSheet()->setCellValue('A2', $dt_buka->nm_karyawan);
            $spreadsheet->getActiveSheet()->setCellValue('A3', 'Buka dari '.date("d M Y H:i", strtotime($dt_buka->created_at)));
            $spreadsheet->getActiveSheet()->setCellValue('A4', 'Sampai '.date("d M Y H:i", strtotime($dt_buka->updated_at)));

            $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:C2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:C3');
            $spreadsheet->getActiveSheet()->mergeCells('A4:C4');

            

            //laporan total
            $spreadsheet->getActiveSheet()->setCellValue('A6', 'Laporan Total');
            $spreadsheet->getActiveSheet()->mergeCells('A6:E6');
            $spreadsheet->getActiveSheet()->setCellValue('A7', 'Jenis Order');
            $spreadsheet->getActiveSheet()->setCellValue('B7', 'Jenis Pembayaran');
            $spreadsheet->getActiveSheet()->setCellValue('C7', 'Jumlah Transaksi');
            $spreadsheet->getActiveSheet()->setCellValue('D7', 'Produk Terjual');
            $spreadsheet->getActiveSheet()->setCellValue('E7', 'Total Penjualan');

            $spreadsheet->getActiveSheet()->getStyle('A6:E7')->applyFromArray($style);


            $spreadsheet->getActiveSheet()->getStyle('A6:E7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            $total_penjualan = 0;
            foreach ($dt_penjualan as $p) {
                $total_penjualan += $p->ttl_penjualan;
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, $p->delivery);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $kolom, $p->pembayaran);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $kolom, number_format($p->jml_invoice,0));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $kolom, number_format($p->produk_terjual,0));
                $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, number_format($p->ttl_penjualan,0));               
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, 'Total');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, number_format($total_penjualan,0));

            $spreadsheet->getActiveSheet()->mergeCells('A'.$kolom.':D'.$kolom);

            $spreadsheet->getActiveSheet()->getStyle('A6:E' . $kolom)->applyFromArray($border_collom);
            //end laporan total

            //detai perproduk
            $spreadsheet->getActiveSheet()->setCellValue('G6', 'Detail Perproduk');
            $spreadsheet->getActiveSheet()->mergeCells('G6:J6');
            $spreadsheet->getActiveSheet()->setCellValue('G7', 'Produk');
            $spreadsheet->getActiveSheet()->setCellValue('H7', 'Order');
            $spreadsheet->getActiveSheet()->setCellValue('I7', 'Terjual');
            $spreadsheet->getActiveSheet()->setCellValue('J7', 'Total');

            $spreadsheet->getActiveSheet()->getStyle('G6:J7')->applyFromArray($style);

            $spreadsheet->getActiveSheet()->getStyle('G6:J7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            $total_produk = 0;
            foreach ($produk as $p) {
                $total_produk += $p->total_terjual;
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, $p->nm_produk);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $kolom, $p->delivery);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $kolom, $p->qty_terjual);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, number_format($p->total_terjual,0));            
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, 'Total');
            $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, number_format($total_produk,0));

            $spreadsheet->getActiveSheet()->mergeCells('G'.$kolom.':I'.$kolom);

            $spreadsheet->getActiveSheet()->getStyle('G6:J' . $kolom)->applyFromArray($border_collom);
            //end detail perproduk

            //laporan stok bawaan
            $spreadsheet->getActiveSheet()->setCellValue('L6', 'Laporan Stok Bawaan');
            $spreadsheet->getActiveSheet()->mergeCells('L6:N6');
            $spreadsheet->getActiveSheet()->setCellValue('L7', 'Barang');
            $spreadsheet->getActiveSheet()->setCellValue('M7', 'Stok Awal');
            $spreadsheet->getActiveSheet()->setCellValue('N7', 'Stok Sisa');

            $spreadsheet->getActiveSheet()->getStyle('L6:N7')->applyFromArray($style);
            
            $spreadsheet->getActiveSheet()->getStyle('L6:N7')->getAlignment()->setWrapText(true);
            $kolom = 8;
            foreach ($dt_stok as $d) {
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setCellValue('L' . $kolom, $d->bahan);
                $spreadsheet->getActiveSheet()->setCellValue('M' . $kolom, $d->stok_masuk.' '.$d->satuan);
                $spreadsheet->getActiveSheet()->setCellValue('N' . $kolom, $d->sisa_stok.' '.$d->satuan);         
                $kolom++;
            }

            $batas = $kolom-1;
            $spreadsheet->getActiveSheet()->getStyle('L6:N' . $batas)->applyFromArray($border_collom);
            //end Lapora Stok Bawaan

            foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
                $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Lapora Penjualan '.$nama_outlet.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function refund(Request $request)
    {
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }

        $banyak_refund = DB::select(DB::raw("SELECT COUNT(invoice_kasir.id) as banyak, SUM(invoice_kasir.total) as total, dt_penjualan.jml_produk, cabang.nama as outlet FROM invoice_kasir
        LEFT JOIN (SELECT cabang_id, SUM(penjualan_kasir.qty) as jml_produk FROM penjualan_kasir WHERE void !=0 AND penjualan_kasir.tgl >= '$tgl1' AND penjualan_kasir.tgl <= '$tgl2' GROUP BY cabang_id) dt_penjualan ON invoice_kasir.cabang_id = dt_penjualan.cabang_id
        LEFT JOIN cabang ON invoice_kasir.cabang_id = cabang.id
        WHERE invoice_kasir.void != 0 AND invoice_kasir.tgl >= '$tgl1' AND invoice_kasir.tgl <= '$tgl2' GROUP BY invoice_kasir.cabang_id"));
        $data = [
            'title' => 'Refund',
            'refund' => InvoiceKasir::where('void','!=',0)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->with(['getPenjualan','getPenjualan.produk','cabang','getPenjualanKaryawan','getPenjualanKaryawan.karyawan','delivery'])->get(),
            'banyak_refund' => $banyak_refund,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        return view('page.refund',$data);
    }

    public function refundInvoice(Request $request)
    {
        if($request->aksi == 'tolak'){
            $data_invoice = [
                'void' => 0,
                'ket_void' => 0,
            ];
            InvoiceKasir::where('no_invoice',$request->no_invoice)->update($data_invoice);

            $data_penjualan = [
                'void' => 0
            ];

            PenjualanKasir::where('no_invoice',$request->no_invoice)->update($data_penjualan);

            $data_komisi = [
                'void' => 0
            ];

            PenjualanKaryawan::where('no_invoice',$request->no_invoice)->update($data_komisi);

            return redirect(route('refund'))->with('success','Refund ditolak');
        }elseif($request->aksi == 'izinkan'){
            $data_invoice = [
                'void' => 2
            ];
            InvoiceKasir::where('no_invoice',$request->no_invoice)->update($data_invoice);

            $data_penjualan = [
                'void' => 2
            ];

            PenjualanKasir::where('no_invoice',$request->no_invoice)->update($data_penjualan);

            $data_komisi = [
                'void' => 2
            ];

            PenjualanKaryawan::where('no_invoice',$request->no_invoice)->update($data_komisi);

            $cek_sudah = Stok::where('no_invoice',$request->no_invoice)->where('jenis','Refund')->first();

            $dt_kota = InvoiceKasir::leftJoin('cabang','invoice_kasir.cabang_id','=','cabang.id')->where('no_invoice',$request->no_invoice)->first();

            if(!$cek_sudah){
                $dt_stok = Stok::where('no_invoice',$request->no_invoice)->get();

                

                if($dt_stok){
                    foreach($dt_stok as $d){

                        $harga = HargaBahan::where('bahan_id',$d->bahan_id)->where('kota_id',$dt_kota->kota_id)->first();
                        $harga_bahan = $harga ? $harga->harga : 0;
                        $data_stok = [
                            'kode' => $d->kode,
                            'no_invoice' => $d->no_invoice,
                            'penjualan_id' => $d->penjualan_id,
                            'produk_id' => $d->produk_id,
                            'cabang_id' => $d->cabang_id,
                            'delivery_id' => $d->delivery_id,
                            'bahan_id' => $d->bahan_id,
                            'debit' => $d->kredit,
                            'kredit' => 0,
                            'harga' => $harga_bahan * $d->kredit,
                            'tgl' => $dt_kota->tgl,
                            'admin' => $d->admin,
                            'jenis' => 'Refund',
                            'status' => $d->status
                        ];        
                        Stok::create($data_stok);
                    }
                    
                }
            }

            PenjualanGaji::where('invoice_id',$dt_kota->id)->update([
                'void' => 1
            ]);

            Jurnal::where('kd_gabungan',$request->no_invoice)->update([
                'void' => 1
            ]);

            return redirect(route('refund'))->with('success','Refund diterima');
        }else{
            return redirect(route('refund'))->with('erorr','Aksi gagal');
        }
    }


    public function editBawaan(Request $request)
    {
        $bahan_id = $request->bahan_id;
        $debit = $request->debit;
        $kode = $request->kode;
        $id = $request->id;

        $id_bahan = $request->id_bahan;
        $takaran = $request->takaran;
        
        BukaToko::where('id',$request->id_buka)->update([
            'nm_karyawan' => $request->nm_karyawan
            ]);

        
        $dt_bahan = Stok::where('kode',$kode)->with('cabang')->first();
        if($id){
            for($count = 0; $count<count($id); $count++){
                $harga = HargaBahan::where('bahan_id',$bahan_id[$count])->where('kota_id',$dt_bahan->cabang->kota_id)->first();
                $harga_bahan = $harga ? $harga->harga : 0;
                $data = [
                    'bahan_id' => $bahan_id[$count],
                    'debit' => $debit[$count],
                    'harga' => $harga_bahan * $debit[$count],
                ];
                Stok::where('id',$id[$count])->update($data);
            }
        }

        if($request->jaga_outlet_id){
            $jaga_outlet_id = $request->jaga_outlet_id;
            $karyawan_id = $request->karyawan_id;

            for($count = 0; $count<count($jaga_outlet_id); $count++){
                JagaOutlet::where('id',$jaga_outlet_id[$count])->update(['karyawan_id' => $karyawan_id[$count]]);
            }
        }

        

        if($id_bahan){
            
            for($count = 0; $count<count($id_bahan); $count++){
                $cek = Stok::where('bahan_id',$id_bahan[$count])->where('kode',$kode)->where('jenis','Masuk')->first();
                if($cek){continue;}
                $harga = HargaBahan::where('bahan_id',$bahan_id[$count])->where('kota_id',$dt_bahan->cabang->kota_id)->first();
                $harga_bahan = $harga ? $harga->harga : 0;
                $data_add = [
                    'kode'=>$kode,
                    'penjualan_id'=>0,
                    'produk_id'=>0,  
                    'cabang_id'=>$dt_bahan->cabang_id,
                    'delivery_id'=>0,
                    'bahan_id' => $id_bahan[$count],
                    'debit' => $takaran[$count],
                    'kredit' => 0,
                    'harga' => $harga_bahan * $takaran[$count],
                    'tgl' => date('Y-m-d'),
                    'admin' => $dt_bahan->admin,
                    'jenis' => 'Masuk',
                    'status' => 'buka'
                ];
                
                Stok::create($data_add);
            }
        }

        return true;

    }

    public function dropBahan(Request $request)
    {
        Stok::find($request->query('id'))->delete();
        return true;
    }

    public function getRefundInvoice(Request $request)
    {

        $data = [

            'dt_invoice' => InvoiceKasir::where('kode',$request->kode)->where('void','!=','2')->with(['getPenjualan.produk','cabang','getPenjualanKaryawan.karyawan','delivery','pembayaran'])->orderBy('id','ASC')->get(),

        ];

        return view('component.refund_invoice',$data);
        
    }

    public function refundDataInvoice(Request $request)
    {
        $data_invoice = [
            'void' => 2
        ];
        InvoiceKasir::where('no_invoice',$request->no_invoice)->update($data_invoice);

        $data_penjualan = [
            'void' => 2
        ];

        PenjualanKasir::where('no_invoice',$request->no_invoice)->update($data_penjualan);

        $data_komisi = [
            'void' => 2
        ];

        PenjualanKaryawan::where('no_invoice',$request->no_invoice)->update($data_komisi);

        $cek_sudah = Stok::where('no_invoice',$request->no_invoice)->where('jenis','Refund')->first();

        $dt_kota = InvoiceKasir::leftJoin('cabang','invoice_kasir.cabang_id','=','cabang.id')->where('no_invoice',$request->no_invoice)->first();

        if(!$cek_sudah){
            $dt_stok = Stok::where('no_invoice',$request->no_invoice)->get();

            

            if($dt_stok){
                foreach($dt_stok as $d){
                    $harga = HargaBahan::where('bahan_id',$d->bahan_id)->where('kota_id',$dt_kota->kota_id)->first();
                    $harga_bahan = $harga ? $harga->harga : 0;
                    $data_stok = [
                        'kode' => $d->kode,
                        'no_invoice' => $d->no_invoice,
                        'penjualan_id' => $d->penjualan_id,
                        'produk_id' => $d->produk_id,
                        'cabang_id' => $d->cabang_id,
                        'delivery_id' => $d->delivery_id,
                        'bahan_id' => $d->bahan_id,
                        'debit' => $d->kredit,
                        'kredit' => 0,
                        'harga' => $harga_bahan * $d->kredit,
                        'tgl' => $dt_kota->tgl,
                        'admin' => $d->admin,
                        'jenis' => 'Refund',
                        'status' => $d->status
                    ];        
                    Stok::create($data_stok);
                }
                
            }
        }

        PenjualanGaji::where('invoice_id',$dt_kota->id)->update([
            'void' => 1
        ]);
        
        
        Jurnal::where('kd_gabungan',$request->no_invoice)->update([
                'void' => 1
            ]);

        return true;
    }

    public function bukaToko(Request $request)
    {
        $data_stok = [
            'status' => 'buka'
        ];
        Stok::where('kode',$request->kode)->update($data_stok);

        $data = [
            'tutup' => null,
        ];
        BukaToko::where('kode',$request->kode)->update($data);

        return true;
        // echo $request->kode;
    }

    public function editKebutuhan(Request $request)
    {
        // return 'ya';
        $id_buka_kebutuhan = $request->id_buka_kebutuhan;
        $id = $request->id;
        $barang_kebutuhan_id = $request->barang_kebutuhan_id;
        $qty = $request->qty;

        $barang_id = $request->barang_id;
        $qty_kebutuhan = $request->qty_kebutuhan;

        BukaToko::where('id',$id_buka_kebutuhan)->update([
            'ket_kebutuhan' => $request->ket_kebutuhan
        ]);
        
        if($id){
            for($count = 0; $count<count($id); $count++){
                Kebutuhan::where('id',$id[$count])->update([
                    'barang_kebutuhan_id' => $barang_kebutuhan_id[$count],
                    'qty' => $qty[$count],
                ]);
            }
        }

        if($barang_id){
            for($count = 0; $count<count($barang_id); $count++){
                Kebutuhan::create([
                    'buka_toko_id' => $id_buka_kebutuhan,
                    'barang_kebutuhan_id' => $barang_id[$count],
                    'qty' => $qty_kebutuhan[$count],
    
                ]);
            }
        }


        return true;
    }

    public function dropKebutuhan(Request $request)
    {
        Kebutuhan::find($request->query('id'))->delete();
        return true;
    }
}
