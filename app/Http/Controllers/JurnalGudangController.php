<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Bahan;
use App\Models\BarangKebutuhan;
use App\Models\HargaBahan;
use App\Models\HargaBahanMitra;
use App\Models\HargaKebutuhan;
use App\Models\HargaKebutuhanMitra;
use App\Models\HargaVarian;
use App\Models\HargaVarianMitra;
use App\Models\Jurnal;
use App\Models\JurnalGudang;
use App\Models\Kota;
use App\Models\Mitra;
use App\Models\Varian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JurnalGudangController extends Controller
{
    public function laporanGudang()
    {


        $bahan = DB::table('bahan')->selectRaw("id as barang_id, bahan as nama, 3 as jenis, 'Bahan' as nm_jenis")->where('aktif','Y')->orderBy('bahan.possition','ASC')->get();

        $varian = DB::table('varian')->selectRaw("id as barang_id, nm_varian as nama, 15 as jenis, 'Saos' as nm_jenis")->where('kategori_varian_id',1)->get();
 
        $barang = DB::table('barang_kebutuhan')->selectRaw("id as barang_id, nm_barang as nama, 14 as jenis, 'Kebutuhan' as nm_jenis")->where('aktif',1)->orderBy('jenis')->get();

        $barang_kebutuhan = BarangKebutuhan::where('aktif',1)->get();

        $data = [
            'title' => 'Accounting',
            'kota' => Kota::all(),
            'mitra' => Mitra::all(),
            'oprasinoal' => AkunPengeluaran::whereIn('jenis_akun_id',[5,3])->get(),
            'barang' => $barang,
            'bahan' => $bahan,
            'varian' => $varian,
            'barang_kebutuhan' => $barang_kebutuhan,
        ];
        return view('page.laporan_gudang',$data);
    }

    public function dtJurnalGudang(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;


        $jurnal = JurnalGudang::select('jurnal_gudang.akun_id','akun_pengeluaran.nm_akun','akun_pengeluaran.jenis_akun_id')->selectRaw("SUM(debit) as ttl_debit, SUM(kredit) as ttl_kredit")->leftJoin('akun_pengeluaran','jurnal_gudang.akun_id','=','akun_pengeluaran.id')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('buku_id','!=',4)->groupBy('akun_id')->get();

        $rusak = JurnalGudang::select('jurnal_gudang.akun_id','akun_pengeluaran.nm_akun','akun_pengeluaran.jenis_akun_id')->selectRaw("SUM(debit) as ttl_debit, SUM(kredit) as ttl_kredit")->leftJoin('akun_pengeluaran','jurnal_gudang.akun_id','=','akun_pengeluaran.id')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('buku_id',4)->groupBy('akun_id')->get();

        $data = [
            'jurnal' => $jurnal,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'rusak' => $rusak,
            'biaya' => AkunPengeluaran::whereIn('jenis_akun_id',[5,3])->get(),
        ];
        return view('component.dt_jurnal_gudang',$data)->render();

    }

    public function addBiayaOprasionalGudang(Request $request)
    {
        $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $data_jurnal [] = [
            'kd_gabungan' => $kd_gabungan,
            'kota_id' => 0,
            'mitra_id' => 0,
            'buku_id' => 2,
            'akun_id' => $request->akun_id,
            'bahan_id' => 0,
            'barang_id' => 0,
            'varian_id' => 0,
            'debit' => $request->biaya,
            'kredit' => 0,
            'qty_debit' => 0,
            'qty_kredit' => 0,
            'user_id' => $admin,
            'tgl' => $request->tgl,
            'ket' => $request->ket,
            'void' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $data_jurnal [] = [
            'kd_gabungan' => $kd_gabungan,
            'kota_id' => 0,
            'mitra_id' => 0,
            'buku_id' => 2,
            'akun_id' => 1,
            'bahan_id' => 0,
            'barang_id' => 0,
            'varian_id' => 0,
            'debit' => 0,
            'kredit' => $request->biaya,
            'qty_debit' => 0,
            'qty_kredit' => 0,
            'user_id' => $admin,
            'tgl' => $request->tgl,
            'ket' => $request->ket,
            'void' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        JurnalGudang::insert($data_jurnal);

        return true;

    }

    public function dtStokBarangGudang(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($bulan_tahun.'-01'));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $dt_bahan = Bahan::select('bahan.bahan','bahan.id')->selectRaw('dt_bahan.saldo_awal, dt_bahan.penjualan, dt_bahan.pembelian, dt_bahan.rusak, dt_bahan.pembelian2, dt_bahan.penjualan2')
        ->leftJoin(
            DB::raw("(SELECT bahan_id, SUM(IF(jurnal_gudang.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(jurnal_gudang.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(jurnal_gudang.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal_gudang.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal_gudang.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal_gudang.buku_id = 3,qty_kredit,0)) as penjualan2 FROM jurnal_gudang WHERE akun_id = 3 AND tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY bahan_id) dt_bahan"), 
                'bahan.id', '=', 'dt_bahan.bahan_id'
        )->where('aktif','Y')->orderBy('bahan.possition','ASC')->get();

        $dt_varian = Varian::select('varian.nm_varian','varian.id')->selectRaw('dt_varian.saldo_awal, dt_varian.penjualan, dt_varian.pembelian, dt_varian.rusak, dt_varian.pembelian2, dt_varian.penjualan2')
        ->leftJoin(
            DB::raw("(SELECT varian_id, SUM(IF(jurnal_gudang.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(jurnal_gudang.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(jurnal_gudang.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal_gudang.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal_gudang.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal_gudang.buku_id = 3,qty_kredit,0)) as penjualan2 FROM jurnal_gudang WHERE akun_id = 15 AND tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY varian_id) dt_varian"), 
                'varian.id', '=', 'dt_varian.varian_id'
        )
        ->where('kategori_varian_id',1)->get();

        $dt_kebutuhan = JurnalGudang::selectRaw("barang_id as id, barang_kebutuhan.nm_barang as nama, SUM(IF(jurnal_gudang.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(jurnal_gudang.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(jurnal_gudang.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal_gudang.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal_gudang.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal_gudang.buku_id = 3,qty_kredit,0)) as penjualan2")->leftJoin('barang_kebutuhan','jurnal_gudang.barang_id','=','barang_kebutuhan.id')
        ->where('jurnal_gudang.akun_id',14)->where('jurnal_gudang.tgl','>=',$tgl1)->where('jurnal_gudang.tgl','<=',$tgl2)->groupBy('barang_id')->get();
        
        $data= [
            'dt_bahan' => $dt_bahan,
            'dt_varian' => $dt_varian,
            'dt_kebutuhan' => $dt_kebutuhan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('component.dt_stok_barang_gudang',$data)->render();
    
    }

    public function saldoAwalPersediaanGudang(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;

        $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

        // $data_jurnal [] = [
        //     'kd_gabungan' => $kd_gabungan,
        //     'kota_id' => 0,
        //     'mitra_id' => 0,
        //     'buku_id' => 3,
        //     'akun_id' => 1,
        //     'bahan_id' => 0,
        //     'barang_id' => 0,
        //     'varian_id' => 0,
        //     'debit' => $request->kas,
        //     'kredit' => 0,
        //     'qty_debit' => 0,
        //     'qty_kredit' => 0,
        //     'user_id' => $admin,
        //     'tgl' => $request->tgl1,
        //     'ket' => 'Saldo Awal Kas',
        //     'void' => 0,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ];

        // $data_jurnal [] = [
        //     'kd_gabungan' => $kd_gabungan,
        //     'kota_id' => 0,
        //     'mitra_id' => 0,
        //     'buku_id' => 3,
        //     'akun_id' => 16,
        //     'bahan_id' => 0,
        //     'barang_id' => 0,
        //     'varian_id' => 0,
        //     'debit' => 0,
        //     'kredit' => $request->kas,
        //     'qty_debit' => 0,
        //     'qty_kredit' => 0,
        //     'user_id' => $admin,
        //     'tgl' => $request->tgl1,
        //     'ket' => 'Saldo Awal Kas',
        //     'void' => 0,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ];

        $month = date("m", strtotime($request->tgl1));
        $year = date("Y", strtotime($request->tgl1));

        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                $dt_harga = Bahan::where('id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;

                

                $check = JurnalGudang::where('ket','Saldo Awal Persediaan')->whereYear('tgl',$year)->whereMonth('tgl',$month)->where('bahan_id',$br_id)->first();
            }elseif($jenis_barang == 14){
                $dt_harga = BarangKebutuhan::where('id',$br_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
                $check = JurnalGudang::where('ket','Saldo Awal Persediaan')->whereYear('tgl',$year)->whereMonth('tgl',$month)->where('barang_id',$br_id)->first();
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                $dt_harga = Varian::where('id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;

                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
                $check = JurnalGudang::where('ket','Saldo Awal Persediaan')->whereYear('tgl',$year)->whereMonth('tgl',$month)->where('varian_id',$br_id)->first();
            }

            if(!$check){
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'kota_id' => 0,
                    'mitra_id' => 0,
                    'buku_id' => 3,
                    'akun_id' => $jenis_barang,
                    'bahan_id' => $bahan_id,
                    'barang_id' => $barang_id,
                    'varian_id' => $varian_id,
                    'debit' => $qty[$count] * $harga_barang,
                    'kredit' => 0,
                    'qty_debit' => $qty[$count],
                    'qty_kredit' => 0,
                    'user_id' => $admin,
                    'tgl' => $request->tgl1,
                    'ket' => 'Saldo Awal Persediaan',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
        
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'kota_id' => 0,
                    'mitra_id' => 0,
                    'buku_id' => 3,
                    'akun_id' => 16,
                    'bahan_id' => $bahan_id,
                    'barang_id' => $barang_id,
                    'varian_id' => $varian_id,
                    'debit' => 0,
                    'kredit' => $qty[$count] * $harga_barang,
                    'qty_debit' => 0,
                    'qty_kredit' => $qty[$count],
                    'user_id' => $admin,
                    'tgl' => $request->tgl1,
                    'ket' => 'Saldo Awal Persediaan',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            
            
        }

        

        JurnalGudang::insert($data_jurnal);

        return true;
    }

    public function editHargaBeli()
    {
        $dt_bahan = Bahan::all();
        foreach($dt_bahan as $d){

            $dt_harga = HargaBahan::where('bahan_id',$d->id)->where('harga_beli','!=',0)->first();

            if($dt_harga){

                Bahan::where('id',$d->id)->update([
                    'harga_beli' => $dt_harga->harga_beli
                ]);

            }

        }

        $dt_varian = Varian::all();
        foreach($dt_varian as $d){

            $dt_harga = HargaVarian::where('varian_id',$d->id)->where('harga_beli','!=',0)->first();

            if($dt_harga){

                Varian::where('id',$d->id)->update([
                    'harga_beli' => $dt_harga->harga_beli
                ]);

            }

        }

        $dt_barang = BarangKebutuhan::all();
        foreach($dt_barang as $d){

            $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$d->id)->where('harga_beli','!=',0)->first();

            if($dt_harga){

                BarangKebutuhan::where('id',$d->id)->update([
                    'harga_beli' => $dt_harga->harga_beli
                ]);

            }

        }

        return 'ya';

    }


    public function barangRusakGudang(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;


        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                $dt_harga = Bahan::where('id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }elseif($jenis_barang == 14){
                $dt_harga = BarangKebutuhan::where('id',$br_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                $dt_harga = Varian::where('id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }
            
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kota_id' => 0,
                'mitra_id' => 0,
                'buku_id' => 4,
                'akun_id' => 19,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $qty[$count] * $harga_barang,
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => '(Barang rusak) '.$request->ket,
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kota_id' => 0,
                'mitra_id' => 0,
                'buku_id' => 4,
                'akun_id' => $jenis_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $qty[$count] * $harga_barang,
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => '(Barang rusak) '.$request->ket,
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        

        JurnalGudang::insert($data_jurnal);

        return true;
    }

    public function pembelianBarangGudang(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;
        $ttl_harga = $request->ttl_harga;


        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                // $dt_harga = Bahan::where('id',$br_id)->first();
                // $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }elseif($jenis_barang == 14){
                // $dt_harga = BarangKebutuhan::where('id',$br_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                // $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                // $dt_harga = Varian::where('id',$br_id)->first();
                // $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }
            
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kota_id' => 0,
                'mitra_id' => 0,
                'buku_id' => 2,
                'akun_id' => $jenis_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $ttl_harga[$count],
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pembelian Barang',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kota_id' => 0,
                'mitra_id' => 0,
                'buku_id' => 2,
                'akun_id' => 1,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $ttl_harga[$count],
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pembelian Barang',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        

        JurnalGudang::insert($data_jurnal);

        return true;
    }

    public function PenjualanBarangGudang(Request $request)
    {

        $admin = Auth::user()->id;

        $data_jurnal = [];

        $data_jurnal_kota = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;
        $kota_id = $request->kota_id;

        $kode_inv = 'PNJ'.date('dmy').strtoupper(Str::random(5));

        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                $akun_barang = 3;

                $dt_harga = HargaBahan::where('kota_id',$kota_id)->where('bahan_id',$br_id)->first();
                $dt_harga_beli = Bahan::where('id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                $harga_beli = $dt_harga_beli->harga_beli;
            }elseif($jenis_barang == 14){
                $dt_harga = HargaKebutuhan::where('kota_id',$kota_id)->where('barang_kebutuhan_id',$br_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;

                $dt_harga_beli = BarangKebutuhan::where('id',$br_id)->first();
                $harga_beli = $dt_harga_beli->harga_beli;

                $akun_barang = 14;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                $dt_harga = HargaVarian::where('kota_id',$kota_id)->where('varian_id',$br_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;

                $dt_harga_beli = Varian::where('id',$br_id)->first();
                $harga_beli = $dt_harga_beli->harga_beli;

                $akun_barang = 15;
            }


            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'kota_id' => $kota_id,
                'mitra_id' => 0,
                'buku_id' => 1,
                'akun_id' => 1,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $harga_barang * $qty[$count],
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Penjualan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'kota_id' => $kota_id,
                'mitra_id' => 0,
                'buku_id' => 1,
                'akun_id' => 2,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $harga_barang * $qty[$count],
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Penjualan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            //barang
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'kota_id' => $kota_id,
                'mitra_id' => 0,
                'buku_id' => 1,
                'akun_id' => 13,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $harga_beli * $qty[$count],
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Bahan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'kota_id' => $kota_id,
                'mitra_id' => 0,
                'buku_id' => 1,
                'akun_id' => $akun_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $harga_beli * $qty[$count],
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Bahan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            //endbarang

            //penjualan kota
            $data_jurnal_kota [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $kota_id,
                'cabang_id' => 0,
                'buku_id' => 2,
                'akun_id' => $jenis_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $qty[$count] * $harga_barang,
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pembelian Barang',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal_kota [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $kota_id,
                'cabang_id' => 0,
                'buku_id' => 2,
                'akun_id' => 1,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $qty[$count] * $harga_barang,
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pembelian Barang',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            //end penjualan kota

        }


        JurnalGudang::insert($data_jurnal);

        Jurnal::insert($data_jurnal_kota);

        return $kode_inv;

        
    }

    public function penjualanBarangMitra(Request $request)
    {

        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;
        $harga_beli = $request->harga_beli;
        $kota_id = $request->kota_id;

        $kode_inv = 'PNJ'.date('dmy').strtoupper(Str::random(5));

        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                $akun_barang = 3;

            }elseif($jenis_barang == 14){
                $barang_id = $br_id;
                $varian_id = 0;


                $akun_barang = 14;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;


                $akun_barang = 15;
            }


            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'mitra_id' => $request->mitra_id,
                'kota_id' => $kota_id,
                'buku_id' => 1,
                'akun_id' => 1,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $harga_beli[$count],
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Penjualan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'mitra_id' => $request->mitra_id,
                'kota_id' => $kota_id,
                'buku_id' => 1,
                'akun_id' => 2,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $harga_beli[$count],
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Penjualan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            //barang
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'mitra_id' => $request->mitra_id,
                'kota_id' => $kota_id,
                'buku_id' => 1,
                'akun_id' => 13,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $harga_beli[$count],
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Bahan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'kode_inv' => $kode_inv,
                'mitra_id' => $request->mitra_id,
                'kota_id' => $kota_id,
                'buku_id' => 1,
                'akun_id' => $akun_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $harga_beli[$count],
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Bahan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            //endbarang

            
        }


        JurnalGudang::insert($data_jurnal);

        return $kode_inv;

        
    }

    public function getSaldoAwalGudang(Request $request)
    {
        $month = date("m", strtotime($request->tgl1));

        $year = date("Y", strtotime($request->tgl1));

        if ($request->jenis == 1) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal_gudang.bahan_id','=','bahan.id')->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('bahan_id',$request->id_barang)->where('akun_id',3)->where('buku_id',3)->first()->toJson();
        } elseif($request->jenis == 2) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal_gudang.varian_id','=','varian.id')->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('varian_id',$request->id_barang)->where('akun_id',15)->where('buku_id',3)->first()->toJson();
        }else{
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal_gudang.barang_id','=','barang_kebutuhan.id')->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('barang_id',$request->id_barang)->where('akun_id',14)->where('buku_id',3)->first()->toJson();
        }
        
        return $dt_jurnal;
    }

    public function editSaldoAwalGudang(Request $request)
    {
        $dt_jurnal = JurnalGudang::where('kd_gabungan',$request->kd_gabungan)->get();

        if($request->jenis == 1){
            

            $dt_harga = Bahan::where('id',$dt_jurnal[0]->bahan_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
        }elseif($request->jenis == 3){
            $dt_harga = BarangKebutuhan::where('id',$dt_jurnal[0]->barang_id)->first();
            
            $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
        }else{
            

            $dt_harga = Varian::where('id',$dt_jurnal[0]->varian_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
        }

        foreach($dt_jurnal as $d){
            if ($d->akun_id == 16) {
                JurnalGudang::where('id',$d->id)->update([
                    'kredit' => $harga_barang * $request->qty,
                    'qty_kredit' => $request->qty,
                ]);
            } else {
                JurnalGudang::where('id',$d->id)->update([
                    'debit' => $harga_barang * $request->qty,
                    'qty_debit' => $request->qty,
                ]);
            }
            
        }

        return true;
    }

    public function getStokMasukGudang(Request $request)
    {

        if ($request->jenis == 1) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal_gudang.bahan_id','=','bahan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('bahan_id',$request->id_barang)->where('akun_id',3)->whereIn('buku_id',[2,5])->get();
        } elseif($request->jenis == 2) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal_gudang.varian_id','=','varian.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('varian_id',$request->id_barang)->where('akun_id',15)->whereIn('buku_id',[2,5])->get();
        }else{
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal_gudang.barang_id','=','barang_kebutuhan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('barang_id',$request->id_barang)->where('akun_id',14)->whereIn('buku_id',[2,5])->get();
        }
        
        return view('component.edit_stok_masuk',['dt_jurnal' => $dt_jurnal, 'jenis' => $request->jenis])->render();
        
    }

    public function editStokMasukGudang(Request $request)
    {
        $kd_gabungan = $request->kd_gabungan;

        $jenis = $request->jenis;

        $qty = $request->qty;

        $tgl = $request->tgl;

        $ttl_harga = $request->ttl_harga;

        for($count = 0; $count<count($kd_gabungan); $count++){

            $dt_jurnal = JurnalGudang::where('kd_gabungan',$kd_gabungan[$count])->get();

            // if($jenis[$count] == 1){
            //     $dt_harga = Bahan::where('id',$dt_jurnal[0]->bahan_id)->first();
            //     $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            // }elseif($jenis[$count] == 3){
            //     $dt_harga = BarangKebutuhan::where('id',$dt_jurnal[0]->barang_id)->first();
            //     $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            // }else{
            //     $dt_harga = Varian::where('id',$dt_jurnal[0]->varian_id)->first();
            //     $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            // }

            foreach($dt_jurnal as $d){
                if ($d->kredit !=0) {
                    JurnalGudang::where('id',$d->id)->update([
                        'kredit' => $ttl_harga[$count],
                        'qty_kredit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                } else {
                    JurnalGudang::where('id',$d->id)->update([
                        'debit' => $ttl_harga[$count],
                        'qty_debit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                }
                
            }

        }

        

        return true;
    }


    public function getStokRusakGudang(Request $request)
    {


        if ($request->jenis == 1) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal_gudang.bahan_id','=','bahan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('bahan_id',$request->id_barang)->where('akun_id',3)->where('buku_id',4)->get();
        } elseif($request->jenis == 2) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal_gudang.varian_id','=','varian.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('varian_id',$request->id_barang)->where('akun_id',15)->where('buku_id',4)->get();
        }else{
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal_gudang.barang_id','=','barang_kebutuhan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('barang_id',$request->id_barang)->where('akun_id',14)->where('buku_id',4)->get();
        }
        
        return view('component.edit_stok_rusak',['dt_jurnal' => $dt_jurnal, 'jenis' => $request->jenis])->render();
        
    }


    public function editStokRusakGudang(Request $request)
    {
        $kd_gabungan = $request->kd_gabungan;

        $jenis = $request->jenis;

        $qty = $request->qty;

        $tgl = $request->tgl;

        for($count = 0; $count<count($kd_gabungan); $count++){

            $dt_jurnal = JurnalGudang::where('kd_gabungan',$kd_gabungan[$count])->get();

            if($jenis[$count] == 1){
                $dt_harga = Bahan::where('id',$dt_jurnal[0]->bahan_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }elseif($jenis[$count] == 3){
                $dt_harga = BarangKebutuhan::where('id',$dt_jurnal[0]->barang_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }else{
                $dt_harga = Varian::where('id',$dt_jurnal[0]->varian_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga_beli : 0;
            }

            foreach($dt_jurnal as $d){
                if ($d->akun_id == 19) {
                    JurnalGudang::where('id',$d->id)->update([
                        'debit' => $harga_barang * $qty[$count],
                        'qty_debit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                } else {
                    JurnalGudang::where('id',$d->id)->update([
                        'kredit' => $harga_barang * $qty[$count],
                        'qty_kredit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                }
                
            }

        }

        return true;
    }

    public function getHargaMitra(Request $request)
    {
        $data_barang = explode( "|", $request->barang_mitra);

        $barang_id = $data_barang[0];
        $jenis = $data_barang[1];


        if($jenis == 3){
            $dt_harga = HargaBahanMitra::where('bahan_id',$barang_id)->where('mitra_id',$request->mitra_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }elseif($jenis == 14){
            $dt_harga = HargaKebutuhanMitra::where('barang_kebutuhan_id',$barang_id)->where('mitra_id',$request->mitra_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }else{
            $dt_harga = HargaVarianMitra::where('varian_id',$barang_id)->where('mitra_id',$request->mitra_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }

        echo $harga_barang;
    }


    public function getHargaKota(Request $request)
    {
        $data_barang = explode( "|", $request->barang);

        $barang_id = $data_barang[0];
        $jenis = $data_barang[1];


        if($jenis == 3){
            $dt_harga = HargaBahan::where('bahan_id',$barang_id)->where('kota_id',$request->kota_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }elseif($jenis == 14){
            $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$barang_id)->where('kota_id',$request->kota_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }else{
            $dt_harga = HargaVarian::where('varian_id',$barang_id)->where('kota_id',$request->kota_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }

        echo $harga_barang;
    }

    public function getStokKeluarGudang(Request $request)
    {


        if ($request->jenis == 1) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal_gudang.bahan_id','=','bahan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('bahan_id',$request->id_barang)->where('akun_id',3)->where('buku_id',1)->with(['kota','mitra'])->get();
        } elseif($request->jenis == 2) {
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal_gudang.varian_id','=','varian.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('varian_id',$request->id_barang)->where('akun_id',15)->where('buku_id',1)->with(['kota','mitra'])->get();
        }else{
            $dt_jurnal = JurnalGudang::select('jurnal_gudang.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal_gudang.barang_id','=','barang_kebutuhan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('barang_id',$request->id_barang)->where('akun_id',14)->where('buku_id',1)->with(['kota','mitra'])->get();
        }
        
        return view('component.edit_stok_keluar_mitra',[
            'dt_jurnal' => $dt_jurnal, 'jenis' => $request->jenis,
            'kota' => Kota::all(),
            'mitra' => Mitra::all(),
            'jenis' => $request->jenis,
            'barang_id' => $request->id_barang,
            ])->render();
        
    }

    public function editStokKeluarMitra(Request $request)
    {
        $kd_gabungan = $request->kd_gabungan;
        $mitra_id = $request->mitra_id;
        $kota_id = $request->kota_id;
        $tgl = $request->tgl;
        $qty = $request->qty;

        if ($request->jenis == 1) {
            for($count = 0; $count<count($kd_gabungan); $count++){
                if ($mitra_id[$count]) {
                    $dt_harga = HargaBahanMitra::where('bahan_id',$request->barang_id)->where('mitra_id',$mitra_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                } else {
                    $dt_harga = HargaBahan::where('bahan_id',$request->barang_id)->where('kota_id',$kota_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }

                $dt_jurnal = JurnalGudang::where('kd_gabungan',$kd_gabungan[$count])->get();

                    foreach($dt_jurnal as $j){
                        if($j->kredit){
                            JurnalGudang::where('id',$j->id)->update([
                                'tgl' => $tgl[$count],
                                'kota_id' => $kota_id[$count],
                                'mitra_id' => $mitra_id[$count],
                                'qty_kredit' => $qty[$count],
                                'kredit' => $qty[$count] * $harga_barang,
                            ]);
                        }else{
                            JurnalGudang::where('id',$j->id)->update([
                                'tgl' => $tgl[$count],
                                'kota_id' => $kota_id[$count],
                                'mitra_id' => $mitra_id[$count],
                                'qty_debit' => $qty[$count],
                                'debit' => $qty[$count] * $harga_barang,
                            ]);
                        }
                    }
                
            }
        }elseif($request->jenis == 2){
            for($count = 0; $count<count($kd_gabungan); $count++){
                if ($mitra_id[$count]) {
                    $dt_harga = HargaVarianMitra::where('varian_id',$request->barang_id)->where('mitra_id',$mitra_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                } else {
                    $dt_harga = HargaVarian::where('varian_id',$request->barang_id)->where('kota_id',$kota_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }
                
            }

            $dt_jurnal = JurnalGudang::where('kd_gabungan',$kd_gabungan[$count])->get();
            foreach($dt_jurnal as $j){
                if($j->kredit){
                    JurnalGudang::where('id',$j->id)->update([
                        'tgl' => $tgl[$count],
                        'kota_id' => $kota_id[$count],
                        'mitra_id' => $mitra_id[$count],
                        'qty_kredit' => $qty[$count],
                        'kredit' => $qty[$count] * $harga_barang,
                    ]);
                }else{
                    JurnalGudang::where('id',$j->id)->update([
                        'tgl' => $tgl[$count],
                        'kota_id' => $kota_id[$count],
                        'mitra_id' => $mitra_id[$count],
                        'qty_debit' => $qty[$count],
                        'debit' => $qty[$count] * $harga_barang,
                    ]);
                }
            }
        }else {
            for($count = 0; $count<count($kd_gabungan); $count++){
                if ($mitra_id[$count]) {
                    $dt_harga = HargaKebutuhanMitra::where('barang_kebutuhan_id',$request->barang_id)->where('mitra_id',$mitra_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                } else {
                    $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$request->barang_id)->where('kota_id',$kota_id[$count])->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }
                
            }

            $dt_jurnal = JurnalGudang::where('kd_gabungan',$kd_gabungan[$count])->get();
            foreach($dt_jurnal as $j){
                if($j->kredit){
                    JurnalGudang::where('id',$j->id)->update([
                        'tgl' => $tgl[$count],
                        'kota_id' => $kota_id[$count],
                        'mitra_id' => $mitra_id[$count],
                        'qty_kredit' => $qty[$count],
                        'kredit' => $qty[$count] * $harga_barang,
                    ]);
                }else{
                    JurnalGudang::where('id',$j->id)->update([
                        'tgl' => $tgl[$count],
                        'kota_id' => $kota_id[$count],
                        'mitra_id' => $mitra_id[$count],
                        'qty_debit' => $qty[$count],
                        'debit' => $qty[$count] * $harga_barang,
                    ]);
                }
            }

        }

        return true;
        
    }

    public function printInvoice($kode_inv)
    {
        return view('page.print_invoice',[
            'dt_jurnal' => JurnalGudang::where('kode_inv',$kode_inv)->where('akun_id',1)->with(['kota','mitra','bahan','varian','kebutuhan'])->get()
        ]);
    }

    public function getHistoryPerinv(Request $request)
    {
        return view('component.history_perinv',[
            'dt_jurnal' => JurnalGudang::select('jurnal_gudang.*')->selectRaw('SUM(kredit) as ttl_kredit')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('buku_id',1)->where('akun_id',2)->groupBy('kode_inv')->orderBy('tgl','DESC')->with(['kota','mitra'])->get()
        ]);
    }

}
