<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\AkunPengeluaran;
use App\Models\Bahan;
use App\Models\BarangKebutuhan;
use App\Models\BukaToko;
use App\Models\Cabang;
use App\Models\Kebutuhan;
use App\Models\Pengeluaran;
use App\Models\PenjualanKasir;
use App\Models\SaldoAwal;
use App\Models\Stok;
use App\Models\StokBaku;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index()
    {

        $data_user = AksesKota::where('user_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->kota_id;
            
        }
        
        

        $data = [
            'title' => 'Accounting',
            'cabang' => Cabang::whereIn('kota_id', $dt_akses)->get(),
            'bulan' => BukaToko::select( DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->orderBy('id','DESC')->take(12)->get()
        ];
        return view('page.accounting',$data);
    }

    public function getManagerStore(Request $request)
    {
        $cabang_id = $request->cabang_id;
        $bulan_tahun = $request->bulan_tahun;
        $first_day1 = $bulan_tahun.'-01';
        $first_day = $first_day1.' 08:00:00';

        $last_day1 = date("Y-m-t", strtotime($first_day1)). ' 06:00:00';

        $last_day    = date('Y-m-d', strtotime('+1 days', strtotime($last_day1)));

        $tgl_last = date("t", strtotime($first_day1));

        $produk = PenjualanKasir::select('produk.id','produk.nm_produk','penjualan_kasir.harga_normal','produk.kategori_id')->leftJoin('produk','penjualan_kasir.produk_id','=','produk.id')->where('cabang_id',$cabang_id)->where('penjualan_kasir.created_at','>=',$first_day)->where('penjualan_kasir.created_at','<=',$last_day)->where('penjualan_kasir.void','!=',2)->groupBy('produk.id')->orderBy('produk.possition','ASC')->get();

        $penjualan = PenjualanKasir::select('penjualan_kasir.produk_id','penjualan_kasir.pembayaran_id','penjualan_kasir.created_at','penjualan_kasir.qty')->selectRaw('(qty * harga_normal) as tot')->where('penjualan_kasir.cabang_id',$cabang_id)->where('penjualan_kasir.created_at','>=',$first_day)->where('penjualan_kasir.created_at','<=',$last_day)->where('penjualan_kasir.void','!=',2)->get();

        $pembayaran = PenjualanKasir::select('pembayaran.id','pembayaran.pembayaran')->leftJoin('pembayaran','penjualan_kasir.pembayaran_id','=','pembayaran.id')->where('cabang_id',$cabang_id)->where('penjualan_kasir.created_at','>=',$first_day)->where('penjualan_kasir.created_at','<=',$last_day)->where('penjualan_kasir.void','!=',2)->groupBy('pembayaran.id')->orderBy('pembayaran.id','ASC')->get();

        $dt_penjualan = [];
        
        $qty_infaq = '';
        $qty_semua = '';

        $total_omset = '';

        for($count = 1; $count<=$tgl_last; $count++){
            $waktu1 = $bulan_tahun.'-'.sprintf("%02d", $count).' 08:00:00';
            $waktu22    = date('Y-m-d', strtotime('+1 days', strtotime($bulan_tahun.'-'.sprintf("%02d", $count))));
            
            $waktu2 = $waktu22.' 06:00:00';
            
            $dt_pn = [];
            $dt_pembayaran = [];

            $tot_omset = 0;
            $tot_pembayaran = 0;

            $tot_qty_infaq = 0;
            $tot_qty_semua = 0;
            foreach($produk as $p){
                $tot_p = 0;
                $qty_p = 0;
                foreach($penjualan as $pn){
                    if($pn->created_at >= $waktu1 && $pn->created_at <= $waktu2 && $pn->produk_id == $p->id){
                        
                        $tot_p += $pn->tot;
                        $qty_p += $pn->qty;

                        $tot_omset += $pn->tot;

                        if($p->kategori_id == 1 || $p->kategori_id == 2){
                            $tot_qty_infaq += $pn->qty;
                        }
                        
                        $tot_qty_semua += $pn->qty;
                    }
                }

                array_push($dt_pn, array(
                    'produk_id' => $p->id,
                    'qty' => $qty_p,
                    'tot' =>$tot_p,
                ));

            }
            if ($count == 1) {
                $qty_infaq  .=  $tot_qty_infaq;
                $qty_semua  .=  $tot_qty_semua;

                $total_omset .= $tot_omset;
            }else{
                $qty_infaq  .= ',' . $tot_qty_infaq;
                $qty_semua  .= ',' . $tot_qty_semua;

                $total_omset .= ',' . $tot_omset;
            }
            

            foreach($pembayaran as $pm){

                $tot_p = 0;
                foreach($penjualan as $dt_pm){
                    if($dt_pm->created_at >= $waktu1 && $dt_pm->created_at <= $waktu2  && $dt_pm->pembayaran_id == $pm->id){
                        
                        $tot_p += $dt_pm->tot;

                        $tot_pembayaran += $dt_pm->tot;
                    }
                }

                array_push($dt_pembayaran, array(
                    'pembayaran_id' => $pm->id,
                    'pembayaran' => $pm->pembayaran,
                    'tot' => $tot_p,
                ));

                
            }

            
            array_push($dt_penjualan, array(
                'tanggal' => $count,
                'penjualan' => $dt_pn,
                'dt_pembayaran' => $dt_pembayaran,
                'tot_omset' => $tot_omset,
                'tot_pembayaran' => $tot_pembayaran,
                // 'tot_qty_infaq' => $tot_qty_infaq,
                // 'tot_qty_semua' => $tot_qty_semua,
            ));
        }

        $aktualisasi_p = [];
        foreach($produk as $p){
            $tot_p = 0;
            $qty_p = 0;
            foreach($penjualan as $pn){
                if($pn->produk_id == $p->id){               
                    $tot_p += $pn->tot;
                    $qty_p += $pn->qty;
                }
            }
            array_push($aktualisasi_p, array(
                'item' => $qty_p,
                'total' => $tot_p,
            ));
        }

        $aktualisasi_pm = [];
        foreach($pembayaran as $pm){
            $tot_p = 0;
            $qty_p = 0;
            foreach($penjualan as $pn){
                if($pn->pembayaran_id == $pm->id){               
                    $tot_p += $pn->tot;
                    $qty_p += $pn->qty;
                }
            }

            array_push($aktualisasi_pm, array(
                'item' => $qty_p,
                'total' => $tot_p,
            ));
        }

        setcookie('qty_infaq', $qty_infaq, time() + (86400 * 30), "/");
        setcookie('qty_semua', $qty_semua, time() + (86400 * 30), "/");
        setcookie('total_omset', $total_omset, time() + (86400 * 30), "/");
        

        $data = [
            'produk' => $produk,
            'pembayaran' => $pembayaran,
            'dt_penjualan' => $dt_penjualan,
            'aktualisasi_p' => $aktualisasi_p,
            'aktualisasi_pm' => $aktualisasi_pm,

        ];
        return view('component.manager_store',$data)->render();

    }

    public function getMsPengeluaran(Request $request)
    {
        $cabang_id = $request->cabang_id;
        $bulan_tahun = $request->bulan_tahun;
        $first_day1 = $bulan_tahun.'-01';
        $first_day = $first_day1.' 08:00:00';

        $last_day1 = date("Y-m-t", strtotime($first_day1)). ' 06:00:00';

        $last_day    = date('Y-m-d', strtotime('+1 days', strtotime($last_day1)));

        $tgl_last = date("t", strtotime($first_day1));

        $bahan = Bahan::select('bahan.id','bahan.harga','bahan.bahan')->leftJoin('stok','bahan.id','=','stok.bahan_id')->where('stok.created_at','>=',$first_day)->where('stok.created_at','<=',$last_day)->where('cabang_id',$cabang_id)->groupBy('bahan.id')->orderBy('bahan.possition')->get();

        $stok = Stok::select('bahan_id','created_at')->selectRaw("SUM(IF(jenis = 'refund',debit,0)) as refund, SUM(kredit) as keluar")->where('stok.created_at','>=',$first_day)->where('stok.created_at','<=',$last_day)->where('cabang_id',$cabang_id)->groupBy('bahan_id')->groupBy('kode')->get();
        
        $dt_stok = [];


        $barang_kebutuhan = BarangKebutuhan::all();
        $kebutuhan = Kebutuhan::select('kebutuhan.barang_kebutuhan_id','qty','kebutuhan.created_at')->leftJoin('buka_toko','kebutuhan.buka_toko_id','=','buka_toko.id')->where('buka_toko.cabang_id',$cabang_id)->where('kebutuhan.created_at','>=',$first_day)->where('kebutuhan.created_at','<=',$last_day)->get();
        $dt_kebutuhan = [];

        $akun_pengeluaran = AkunPengeluaran::select('akun_pengeluaran.id','akun_pengeluaran.nm_akun')->selectRaw('dt_pengeluaran_id.pengeluaran_id, pengeluaran.harga')
        ->leftJoin(
            DB::raw("(SELECT akun_pengeluaran_id, MAX(id) as pengeluaran_id FROM pengeluaran WHERE cabang_id = 1 GROUP BY cabang_id, akun_pengeluaran_id) dt_pengeluaran_id"), 
                'akun_pengeluaran.id', '=', 'dt_pengeluaran_id.akun_pengeluaran_id'
        )
        ->leftJoin('pengeluaran','dt_pengeluaran_id.pengeluaran_id','=','pengeluaran.id')
        ->get();

        $month = date("m", strtotime($first_day));
        $year = date("Y", strtotime($first_day));

        $pengeluaran = Pengeluaran::whereMonth('pengeluaran.tgl',$month)->whereYear('pengeluaran.tgl',$year)->where('pengeluaran.cabang_id',$cabang_id)->get();
        $dt_pengeluaran = [];

        $saldo_awal = SaldoAwal::whereMonth('saldo_awal.tgl',$month)->whereYear('saldo_awal.tgl',$year)->where('saldo_awal.cabang_id',$cabang_id)->get();
        $dt_saldo_awal = [];

        
        $stok_barang = StokBarang::select('bahan_baku_id','tgl','cabang_id','jenis_data')->selectRaw("SUM(debit) as ttl_debit, SUM(kredit) as ttl_kredit")->whereMonth('stok_barang.tgl',$month)->whereYear('stok_barang.tgl',$year)->where('stok_barang.cabang_id',$cabang_id)->groupBy('bahan_baku_id')->groupBy('jenis_data')->get();
        $dt_stok_barang = [];

        $stok_baku = StokBaku::where('cabang_id',$cabang_id)->get();
        $dt_stok_baku = [];

        for($count = 1; $count<=$tgl_last; $count++){
            $waktu1 = $bulan_tahun.'-'.sprintf("%02d", $count).' 08:00:00';
            $waktu22    = date('Y-m-d', strtotime('+1 days', strtotime($bulan_tahun.'-'.sprintf("%02d", $count))));
            
            $waktu2 = $waktu22.' 06:00:00';
            $dt_bahan = [];

            $tot_bahan = 0;
            foreach($bahan as $b){
                $tot_keluar = 0;
                $tot_refund = 0;


                foreach($stok as $s){
                    if($s->created_at >= $waktu1 && $s->created_at <= $waktu2  && $s->bahan_id == $b->id){
                        
                        $tot_keluar += $s->keluar;

                        $tot_refund += $s->refund;

                        $tot_bahan += $b->harga * ($s->keluar - $s->refund);
                    }
                    
                }

                array_push($dt_bahan, array(
                    'bahan_id' => $b->id,
                    'harga' => $b->harga,
                    'tot_keluar' => $tot_keluar,
                    'tot_refund' => $tot_refund,
                ));

                
                
            }

            array_push($dt_stok, array(
                'tanggal' => $count,
                'dt_bahan' => $dt_bahan,
                'tot_bahan' => $tot_bahan,
            ));

            $data_kebutuhan = [];
            $tot_kebutuhan = 0;
            foreach($barang_kebutuhan as $bk){
                $tot_qty = 0;
                $tot_harga = 0;
                
                foreach($kebutuhan as $k){
                    if($k->created_at >= $waktu1 && $k->created_at <= $waktu2  && $k->barang_kebutuhan_id == $bk->id){
                        $tot_qty += $k->qty;
                        $tot_harga += ($k->qty * $bk->harga);
                        $tot_kebutuhan += ($k->qty * $bk->harga);
                    }
                }

                array_push($data_kebutuhan, array(
                    'barang_kebutuhan_id' => $bk->id,
                    'harga' => $bk->harga,
                    'tot_qty' => $tot_qty,
                    'tot_harga' => $tot_harga,
                ));
            }

            array_push($dt_kebutuhan, array(
                'tanggal' => $count,
                'data_kebutuhan' => $data_kebutuhan,
                'tot_kebutuhan' => $tot_kebutuhan,
            ));

            //pengeluaran
            $tgl = $bulan_tahun.'-'.sprintf("%02d", $count);
            $data_pengeluaran = [];
            $tot_pengeluaran = 0;
            foreach($akun_pengeluaran as $ap){
                $tot_qty = 0;
                $tot_harga = 0;
                
                $hitung = 0;
                $pengeluaran_id = 0;
                foreach($pengeluaran as $p){
                    if($p->tgl == $tgl  && $p->akun_pengeluaran_id == $ap->id){
                        $tot_qty += $p->qty;
                        $tot_harga += ($p->qty * $p->harga);
                        $tot_pengeluaran += ($p->qty * $p->harga);

                        $pengeluaran_id = $p->id;
                        $harga = $p->harga;
                        $hitung ++;
                    }
                }

                if($hitung){
                    array_push($data_pengeluaran, array(
                        'pengeluaran_id' => $pengeluaran_id,
                        'akun_pengeluaran_id' => $ap->id,
                        'harga' => $harga,
                        'tot_qty' => $tot_qty,
                        'tot_harga' => $tot_harga,
                        'tgl' => $tgl,
                        'cabang_id' => $cabang_id,
                    ));
                }else{
                    array_push($data_pengeluaran, array(
                        'pengeluaran_id' => null,
                        'akun_pengeluaran_id' => $ap->id,
                        'harga' => $ap->harga,
                        'tot_qty' => $tot_qty,
                        'tot_harga' => $tot_harga,
                        'tgl' => $tgl,
                        'cabang_id' => $cabang_id,
                    ));
                }
                
            }

            array_push($dt_pengeluaran, array(
                'tanggal' => $count,
                'data_pengeluaran' => $data_pengeluaran,
                'tot_pengeluaran' => $tot_pengeluaran,
            ));
            //endpengeluaran

        }

        $aktualisasi_bahan = [];
        foreach($bahan as $b){
            $tot_qty = 0;
            $tot_harga = 0;
            $tot_saldo_awal = 0;

            $tot_debit_barang = 0;
            $tot_kredit_barang = 0;

            $tot_stok_baku = 0;
            foreach($stok as $s){
                if($s->bahan_id == $b->id){               
                    $tot_qty += ($s->keluar - $s->refund);
                    $tot_harga += $b->harga * ($s->keluar - $s->refund);
                }
            }

            array_push($aktualisasi_bahan, array(
                'item' => $tot_qty ,
                'total' => $tot_harga,
            ));

            $saldo_awal_id = 0;
            foreach($saldo_awal as $sa){
                if($sa->bahan_baku_id == $b->id && $sa->jenis_data == 1){
                    $tot_saldo_awal += $sa->stok_awal;
                    $saldo_awal_id = $sa->id;
                }
            }

            array_push($dt_saldo_awal, array(
                'id' => $b->id,
                'saldo_awal_id' => $saldo_awal_id,
                'nm_item' => $b->bahan,
                'harga' => $b->harga,
                'jenis_data' => 1,
                'saldo_awal' => $tot_saldo_awal,
                'month' => $month,
                'year' => $year,
            ));

            foreach($stok_barang as $sb){
                if($sb->bahan_baku_id == $b->id && $sb->jenis_data == 1){
                    $tot_debit_barang += $sb->ttl_debit;
                    $tot_kredit_barang += $sb->ttl_kredit;
                }
            }

            array_push($dt_stok_barang, array(
                'id' => $b->id,
                'harga' => $b->harga,
                'jenis_data' => 1,
                'debit_barang' => $tot_debit_barang,
                'kredit_barang' => $tot_kredit_barang,
                'month' => $month,
                'year' => $year,
                'cabang_id' => $cabang_id,
                'nm_item' => $b->bahan,
            ));

            $stok_baku_id = 0;
            foreach($stok_baku as $sbk){
                if($sbk->bahan_baku_id == $b->id && $sbk->jenis_data == 1){
                    $tot_stok_baku += $sbk->stok_baku;
                    $stok_baku_id = $sbk->id;
                }
            }

            array_push($dt_stok_baku, array(
                'id' => $b->id,
                'stok_baku' => $tot_stok_baku,
                'jenis_data' => 1,
                'month' => $month,
                'year' => $year,
                'cabang_id' => $cabang_id,
                'nm_item' => $b->bahan,
                'stok_baku_id' => $stok_baku_id,
            ));
        }

        $aktualisasi_kebutuhan = [];
        foreach($barang_kebutuhan as $kb){
            $tot_qty = 0;
            $tot_harga = 0;

            $tot_saldo_awal = 0;

            $tot_debit_barang = 0;
            $tot_kredit_barang = 0;

            $tot_stok_baku = 0;
            foreach($kebutuhan as $k){
                if($k->barang_kebutuhan_id == $kb->id){               
                    $tot_qty += $k->qty;
                    $tot_harga += ($kb->harga * $k->qty);
                }
            }

            array_push($aktualisasi_kebutuhan, array(
                'item' => $tot_qty ,
                'total' => $tot_harga,
            ));

            $saldo_awal_id = 0;
            foreach($saldo_awal as $sa){
                if($sa->bahan_baku_id == $kb->id && $sa->jenis_data == 2){
                    $tot_saldo_awal += $sa->stok_awal;
                    $saldo_awal_id = $sa->id;
                }
            }

            array_push($dt_saldo_awal, array(
                'id' => $kb->id,
                'saldo_awal_id' => $saldo_awal_id,
                'nm_item' => $kb->nm_barang,
                'harga' => $kb->harga,
                'jenis_data' => 2,
                'saldo_awal' => $tot_saldo_awal,
                'month' => $month,
                'year' => $year,
            ));

            foreach($stok_barang as $sb){
                if($sb->bahan_baku_id == $kb->id && $sb->jenis_data == 2){
                    $tot_debit_barang += $sb->ttl_debit;
                    $tot_kredit_barang += $sb->ttl_kredit;
                }
            }

            array_push($dt_stok_barang, array(
                'id' => $kb->id,
                'harga' => $kb->harga,
                'jenis_data' => 2,
                'debit_barang' => $tot_debit_barang,
                'kredit_barang' => $tot_kredit_barang,
                'month' => $month,
                'year' => $year,
                'nm_item' => $kb->nm_barang,
                'cabang_id' => $cabang_id,
            ));

            $stok_baku_id = 0;
            foreach($stok_baku as $sbk){
                if($sbk->bahan_baku_id == $kb->id && $sbk->jenis_data == 2){
                    $tot_stok_baku += $sbk->stok_baku;
                    $stok_baku_id = $sbk->id;
                }
            }

            array_push($dt_stok_baku, array(
                'id' => $kb->id,
                'stok_baku' => $tot_stok_baku,
                'jenis_data' => 2,
                'month' => $month,
                'year' => $year,
                'cabang_id' => $cabang_id,
                'nm_item' => $kb->nm_barang,
                'stok_baku_id' => $stok_baku_id
            ));
        }

        //pengeluaran
        $aktualisasi_pengeluaran = [];
        foreach($akun_pengeluaran as $ap){
            $tot_qty = 0;
            $tot_harga = 0;

            $tot_saldo_awal = 0;

            $tot_debit_barang = 0;
            $tot_kredit_barang = 0;

            $tot_stok_baku = 0;
            foreach($pengeluaran as $p){
                if($p->akun_pengeluaran_id == $ap->id){               
                    $tot_qty += $p->qty;
                    $tot_harga += ($ap->harga * $p->qty);

                }
            }

            array_push($aktualisasi_pengeluaran, array(
                'item' => $tot_qty ,
                'total' => $tot_harga,
            ));

            $saldo_awal_id = 0;
            foreach($saldo_awal as $sa){
                if($sa->bahan_baku_id == $ap->id && $sa->jenis_data == 3){
                    $tot_saldo_awal += $sa->stok_awal;
                    $saldo_awal_id = $sa->id;
                }
            }

            array_push($dt_saldo_awal, array(
                'id' => $ap->id,
                'saldo_awal_id' => $saldo_awal_id,
                'nm_item' => $ap->nm_akun,
                'harga' => $ap->harga,
                'jenis_data' => 3,
                'saldo_awal' => $tot_saldo_awal,
                'month' => $month,
                'year' => $year,
            ));



            foreach($stok_barang as $sb){
                if($sb->bahan_baku_id == $ap->id && $sb->jenis_data == 3){
                    $tot_debit_barang += $sb->ttl_debit;
                    $tot_kredit_barang += $sb->ttl_kredit;
                }
            }

            array_push($dt_stok_barang, array(
                'id' => $ap->id,
                'harga' => $ap->harga,
                'jenis_data' => 3,
                'debit_barang' => $tot_debit_barang,
                'kredit_barang' => $tot_kredit_barang,
                'month' => $month,
                'year' => $year,
                'nm_item' => $ap->nm_akun,
                'cabang_id' => $cabang_id,
            ));

            $stok_baku_id = 0;
            foreach($stok_baku as $sbk){
                if($sbk->bahan_baku_id == $ap->id && $sbk->jenis_data == 3){
                    $tot_stok_baku += $sbk->stok_baku;
                    $stok_baku_id = $sbk->id;
                }
            }

            array_push($dt_stok_baku, array(
                'id' => $ap->id,
                'stok_baku' => $tot_stok_baku,
                'jenis_data' => 3,
                'month' => $month,
                'year' => $year,
                'cabang_id' => $cabang_id,
                'nm_item' => $ap->nm_akun,
                'stok_baku_id' => $stok_baku_id,
            ));
        }
        //endpengeluaran

        return view('component.ms_pengeluaran',[
            'dt_stok' => $dt_stok,
            'dt_kebutuhan' => $dt_kebutuhan,
            'dt_pengeluaran' => $dt_pengeluaran,
            'bahan' => $bahan,
            'barang_kebutuhan' => $barang_kebutuhan,
            'akun_pengeluaran' => $akun_pengeluaran,
            'aktualisasi_bahan' => $aktualisasi_bahan,
            'aktualisasi_kebutuhan' => $aktualisasi_kebutuhan,
            'aktualisasi_pengeluaran' => $aktualisasi_pengeluaran,
            'dt_saldo_awal' => $dt_saldo_awal,
            'dt_stok_barang' => $dt_stok_barang,
            'dt_stok_baku' => $dt_stok_baku
        ])->render();
    }

    public function inputPengeluaran(Request $request)
    {
        Pengeluaran::create([
            'akun_pengeluaran_id' => $request->akun_pengeluaran_id,
            'harga' => $request->harga,
            'qty' => $request->qty,
            'cabang_id' => $request->cabang_id,
            'tgl' => $request->tgl,
            'user_id' => Auth::user()->id,
        ]);

        return true;
    }

    public function editPengeluaran(Request $request)
    {
        Pengeluaran::where('id',$request->pengeluaran_id)
        ->update([
            'qty' => $request->qty,
            'harga' => $request->harga,
        ]);

        return true;
    }

    public function inputSaldoAwal(Request $request)
    {
        SaldoAwal::create([
            'cabang_id' => $request->cabang_id,
            'bahan_baku_id' => $request->id_barang,
            'stok_awal' => $request->saldo_awal,
            'tgl' => $request->bulan_tahun.'-01',
            'jenis_data' => $request->jenis_data,
            'user_id' => Auth::user()->id
        ]);

        return true;
    }

    public function editSaldoAwal(Request $request)
    {
        SaldoAwal::where('id',$request->saldo_awal_id)->update([
            'stok_awal' => $request->saldo_awal
        ]);

        return true;
    }

    public function getDataStokBarang(Request $request)
    {
        $month = date("m", strtotime($request->bulan_tahun.'-01'));
        $year = date("Y", strtotime($request->bulan_tahun.'-01'));
        return view('component.stok_barang',[
            'dt_stok_barang' => StokBarang::where('bahan_baku_id',$request->id_barang)->where('jenis_data',$request->jenis_data)->where('cabang_id',$request->cabang_id)->where('debit','!=',0)->whereMonth('tgl',$month)->whereYear('tgl',$year)->get(),
        ])->render();
    }

    public function stokBarang(Request $request)
    {
        $id = $request->id;
        $debit = $request->debit;
        $tgl = $request->tgl;

        $tgl_input = $request->tgl_input;
        $debit_input = $request->debit_input;
        if ($tgl_input && $debit_input) {
            for($count = 0; $count<count($tgl_input); $count++){
                StokBarang::create([
                    'cabang_id' => $request->cabang_id,
                    'bahan_baku_id' => $request->bahan_baku_id,
                    'debit' => $debit_input[$count],
                    'kredit' => 0,
                    'tgl' => $tgl_input[$count],
                    'jenis_data' => $request->jenis_data,
                    'user_id' => Auth::user()->id,

                ]);
            }
        }

        if($id){
            for($count = 0; $count<count($id); $count++){
                StokBarang::where('id',$id[$count])->update([
                    'debit' => $debit[$count],
                    'tgl' => $tgl[$count],
                ]);
            }
        }

        return true;;
    }

    public function inputStokBaku(Request $request)
    {
        StokBaku::create([
            'cabang_id' => $request->cabang_id,
            'bahan_baku_id' => $request->bahan_baku_id,
            'stok_baku' => $request->stok_baku,
            'jenis_data' => $request->jenis_data,
            'user_id' => Auth::user()->id,
        ]);

        return true;
    }

    public function editStokBaku(Request $request)
    {
        StokBaku::where('id',$request->id)->update([
            'stok_baku' => $request->stok_baku
        ]);

        return true;
    }

}
