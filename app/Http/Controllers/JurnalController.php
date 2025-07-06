<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\AkunPengeluaran;
use App\Models\Bahan;
use App\Models\BarangKebutuhan;
use App\Models\BukaToko;
use App\Models\Cabang;
use App\Models\Gapok;
use App\Models\GapokOffice;
use App\Models\HargaBahan;
use App\Models\HargaKebutuhan;
use App\Models\HargaPengeluaran;
use App\Models\HargaVarian;
use App\Models\Jurnal;
use App\Models\Karyawan;
use App\Models\KaryawanOffice;
use App\Models\karyawanOfficeKota;
use App\Models\KasBarang;
use App\Models\Kota;
use App\Models\PenjualanKasir;
use App\Models\PenjualanVarian;
use App\Models\PersenInvestor;
use App\Models\Stok;
use App\Models\Varian;
use App\Models\ViewJurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JurnalController extends Controller
{
    public function laporanJurnal()
    {

        $data_user = AksesKota::where('user_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->kota_id;
            
        }

        $bahan = DB::table('bahan')->selectRaw("id as barang_id, bahan as nama, 3 as jenis, 'Bahan' as nm_jenis")->where('aktif','Y')->orderBy('bahan.possition','ASC')->get();

        $varian = DB::table('varian')->selectRaw("id as barang_id, nm_varian as nama, 15 as jenis, 'Saos' as nm_jenis")->where('kategori_varian_id',1)->get();
 
        $barang = DB::table('barang_kebutuhan')->selectRaw("id as barang_id, nm_barang as nama, 14 as jenis, 'Kebutuhan' as nm_jenis")->where('aktif',1)->orderBy('jenis')->get();

        $barang_kebutuhan = BarangKebutuhan::where('aktif',1)->get();

        $data = [
            'title' => 'Accounting',
            'kota' => Kota::whereIn('id', $dt_akses)->get(),
            'cabang' => Cabang::whereIn('kota_id', $dt_akses)->orderBy('kota_id','ASC')->orderBy('possition','ASC')->get(),
            'bulan' => Jurnal::select( DB::raw('YEAR(tgl) year, MONTH(tgl) month'))
            ->groupby('year','month')
            ->orderBy('id','DESC')->take(12)->get(),
            'oprasinoal' => AkunPengeluaran::whereIn('jenis_akun_id',[5,3])->get(),
            'barang' => $barang,
            'bahan' => $bahan,
            'varian' => $varian,
            'barang_kebutuhan' => $barang_kebutuhan,
            'cabang' => Cabang::all(),
        ];
        return view('page.laporan_jurnal',$data);
    }

    public function dtJurnal(Request $request)
    {
        
        $data_user = PersenInvestor::where('investor_id',Auth::user()->id)->get();
        $dt_akses = [];
        foreach($data_user as $da){
            
                $dt_akses [] = $da->cabang_id;
            
        }

        $akses_cabang = join(",",$dt_akses);

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;


        // $biaya_oprational = AkunPengeluaran::select('akun_pengeluaran.id','nm_akun','jenis_akun_id')->selectRaw('dt_jurnal.ttl_debit')->leftJoin(
        //     DB::raw("(SELECT akun_id, SUM(debit) as ttl_debit FROM jurnal WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND cabang_id IN($akses_cabang) AND void = 0 GROUP BY akun_id) dt_jurnal"), 
        //         'akun_pengeluaran.id', '=', 'dt_jurnal.akun_id'
        // )->whereIn('jenis_akun_id',[5,3])->get();
        // $penjualan = PenjualanKasir::selectRaw('SUM(qty * harga_normal) as tot_penjualan')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->whereIn('penjualan_kasir.cabang_id',$dt_akses)->where('void','!=',2)->first();

        // $barang_kebutuhan = Jurnal::selectRaw("SUM(kredit) as ttl_kebutuhan")->whereIn('cabang_id',$dt_akses)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->where('akun_id',14)->first();
        

        // $dt_gaji_persen_office = karyawanOfficeKota::select('karyawan_office_kota.cabang_id')->selectRaw("dt_penjualan.ttl_penjualan, (IF(SUM(karyawan_office.persen) > 0, SUM(karyawan_office.persen) * dt_penjualan.ttl_penjualan / 100,0)) as ttl_gaji_persen")
        // ->leftJoin('karyawan_office','karyawan_office_kota.karyawan_id','=','karyawan_office.id')
        // ->leftJoin(
        //     DB::raw("(SELECT cabang_id, SUM(qty * harga_normal) as ttl_penjualan FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND penjualan_kasir.void !=2 GROUP BY cabang_id) dt_penjualan"),
        //     'karyawan_office_kota.cabang_id','=','dt_penjualan.cabang_id'
        // )
        // ->whereIn('karyawan_office_kota.cabang_id',$dt_akses)
        // ->groupBy('karyawan_office_kota.cabang_id')
        // ->get();

        // $persen_office = 0;


        // foreach ($dt_gaji_persen_office as $d) {
        //     $persen_office += $d->ttl_gaji_persen;
        // }

        // $dt_gapok_crew = Cabang::selectRaw("IF(dt_cabang.jml_cabang > 0 AND dt_gapok.jml_gapok > 0 , dt_gapok.jml_gapok / dt_cabang.jml_cabang,0) as ttl_gapok")
        // ->leftJoin(
        //     DB::raw("(SELECT kota_id, SUM(gapok) as jml_gapok FROM gapok WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY kota_id) dt_gapok"),
        //     'cabang.kota_id','=','dt_gapok.kota_id'
        // )
        // ->leftJoin(
        //     DB::raw("(SELECT kota_id, COUNT(id) as jml_cabang FROM cabang GROUP BY kota_id) dt_cabang"),
        //     'cabang.kota_id','=','dt_cabang.kota_id'
        // )
        // ->whereIn('cabang.id',$dt_akses)
        // ->groupBy('cabang.id')
        // ->get();

        // $gapok_crew = 0;
        // foreach ($dt_gapok_crew as $d) {
        //     $gapok_crew += $d->ttl_gapok;
        // }

        // $persen_investor = PersenInvestor::selectRaw("IF(dt_laba.ttl_laba > 0 AND persen_investor.persen > 0, (persen_investor.persen * dt_laba.ttl_laba)/100,0) AS tot_investor")
        // ->leftJoin(
        //     DB::raw("(SELECT id, SUM(laba_rugi) AS ttl_laba FROM view_jurnal WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY id) dt_laba"),
        //     'persen_investor.cabang_id','=','dt_laba.id'
        // )
        // ->where('investor_id',Auth::user()->id)->get();

        // $ttl_persen_investor = 0;

        // foreach($persen_investor as $d){
        //     $ttl_persen_investor += $d->tot_investor;
        // }

        $dt_jurnal = ViewJurnal::selectRaw("SUM(laba_rugi) as sum_laba, SUM(ttl_stok) as sum_stok, SUM(ttl_varian) as sum_varian, SUM(ttl_barang_kebutuhan) as sum_kebutuhan, SUM(ttl_penjualan) as sum_penjualan, SUM(ttl_gapok_office + ttl_persen_crew + ttl_persen_office + ttl_gapok_crew) as sum_gaji, SUM(ttl_investor) as sum_investor, SUM(ttl_biaya_oprasional) as sum_biaya")->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->whereIn('id',$dt_akses)->first();

        dd($dt_jurnal);

        $data = [
            // 'stok' => Stok::selectRaw("SUM(IF(jenis = 'Keluar',harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', harga,0)) as harga_refund")->where('stok.tgl','>=',$tgl1)->where('stok.tgl','<=',$tgl2)->whereIn('stok.cabang_id',$dt_akses)->whereIn('jenis',['Keluar','Refund'])->first(),
            // 'varian' => PenjualanVarian::selectRaw("SUM(penjualan_varian.harga) as ttl_varian")->leftJoin('penjualan_kasir','penjualan_varian.penjualan_id','=','penjualan_kasir.id')->where('penjualan_varian.tgl','>=',$tgl1)->where('penjualan_varian.tgl','<=',$tgl2)->whereIn('penjualan_kasir.cabang_id',$dt_akses)->where('penjualan_kasir.void','!=',2)->first(),
            // 'biaya_oprational' => $biaya_oprational,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            // 'penjualan' => $penjualan,
            // 'barang_kebutuhan' => $barang_kebutuhan,
            // 'gapok_crew' => $gapok_crew ? $gapok_crew : 0,
            // 'gapok_office' => GapokOffice::selectRaw("SUM(gapok_office.gapok) as ttl_gapok")->whereIn('gapok_office.cabang_id',$dt_akses)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->first(),
            // 'persen_office' => $persen_office,
            // // 'persen_investor' => $persen_investor,
            // 'ttl_persen_investor' => $ttl_persen_investor,

            'data_jurnal' => $dt_jurnal

        ];
        return view('component.dt_jurnal',$data)->render();

    }

    public function dtPerOutlet(Request $request)
    {
        // $first = $request->bulan_tahun.'-01';
        // $last = date("Y-m-t", strtotime($request->bulan_tahun.'-01'));
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;


        $cabang_id = $request->cabang_id;

        $biaya_oprational = AkunPengeluaran::select('akun_pengeluaran.id','nm_akun','jenis_akun_id')->selectRaw('dt_jurnal.ttl_debit')->leftJoin(
            DB::raw("(SELECT akun_id, SUM(debit) as ttl_debit FROM jurnal WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND cabang_id = $cabang_id AND void = 0 GROUP BY akun_id) dt_jurnal"), 
                'akun_pengeluaran.id', '=', 'dt_jurnal.akun_id'
        )->whereIn('jenis_akun_id',[5,3])->get();
        // $jurnal = Jurnal::select('akun_id')->selectRaw('SUM(debit) as ttl_debit, SUM(kredit) as ttl_kredit')->where('tgl','<=',$last)->where('kota_id',1)->where('void',0)->groupBy('akun_id')->with('akun')->get();
        // dd($jurnal);
        $penjualan = PenjualanKasir::selectRaw('SUM(qty * harga_normal) as tot_penjualan')->leftJoin('cabang','penjualan_kasir.cabang_id','=','cabang.id')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('cabang.id',$cabang_id)->where('void','!=',2)->first();

        $barang_kebutuhan = Jurnal::selectRaw("SUM(kredit) as ttl_kebutuhan")->where('cabang_id',$cabang_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->where('akun_id',14)->groupBy('cabang_id')->first();
        

        // $dt_gaji_persen_office = karyawanOfficeKota::select('cabang.id','cabang.nama','cabang.kota_id','karyawan_office_kota.cabang_id')->selectRaw("dt_penjualan.ttl_penjualan, (IF(SUM(karyawan_office.persen) > 0, SUM(karyawan_office.persen) * dt_penjualan.ttl_penjualan / 100,0)) as ttl_gaji_persen")
        // ->leftJoin('cabang','karyawan_office_kota.cabang_id','=','cabang.id')
        // ->leftJoin('karyawan_office','karyawan_office_kota.karyawan_id','=','karyawan_office.id')
        // ->leftJoin(
        //     DB::raw("(SELECT cabang_id, SUM(harga_normal) as ttl_penjualan FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND penjualan_kasir.void !=2 GROUP BY cabang_id) dt_penjualan"),
        //     'karyawan_office_kota.cabang_id','=','dt_penjualan.cabang_id'
        // )
        // ->where('cabang.kota_id',$kota_id)
        // ->groupBy('karyawan_office_kota.cabang_id')
        // ->get();

        // $persen_office = 0;
        // foreach ($dt_gaji_persen_office as $d) {
        //     $persen_office += $d->ttl_gaji_persen;
        // }

        $dt_gaji_persen_office = karyawanOfficeKota::selectRaw("IF(SUM(karyawan_office.persen) > 0 AND dt_penjualan.ttl_penjualan > 0 , SUM(karyawan_office.persen) * dt_penjualan.ttl_penjualan/100,0) as persen_office")
        ->leftJoin('karyawan_office','karyawan_office_kota.karyawan_id','=','karyawan_office.id')
        ->leftJoin(
                DB::raw("(SELECT cabang_id, SUM(qty * harga_normal) as ttl_penjualan FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND penjualan_kasir.void !=2 AND cabang_id = $cabang_id GROUP BY cabang_id) dt_penjualan"),
                'karyawan_office_kota.cabang_id','=','dt_penjualan.cabang_id'
            )
        ->where('karyawan_office_kota.cabang_id',$cabang_id)->groupBy('karyawan_office_kota.cabang_id')->first();

        $dt_persen_investor = PersenInvestor::selectRaw("IF(SUM(persen_investor.persen) > 0 AND dt_penjualan.ttl_penjualan > 0 , SUM(persen_investor.persen) * dt_penjualan.ttl_penjualan/100,0) as persen_investor")
        ->leftJoin(
                DB::raw("(SELECT cabang_id, SUM(qty * harga_normal) as ttl_penjualan FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND penjualan_kasir.void !=2 AND cabang_id = $cabang_id GROUP BY cabang_id) dt_penjualan"),
                'persen_investor.cabang_id','=','dt_penjualan.cabang_id'
            )
        ->where('persen_investor.cabang_id',$cabang_id)->groupBy('persen_investor.cabang_id')->first();

        $persen_office = $dt_gaji_persen_office ? $dt_gaji_persen_office->persen_office : 0;

        $persen_investor = $dt_persen_investor ? $dt_persen_investor->persen_investor : 0;

        $gapok_crew = Cabang::selectRaw("IF(dt_cabang.jml_cabang > 0 AND dt_gapok.jml_gapok > 0 , dt_gapok.jml_gapok / dt_cabang.jml_cabang,0) as ttl_gapok")
        ->leftJoin(
            DB::raw("(SELECT kota_id, SUM(gapok) as jml_gapok FROM gapok WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY kota_id) dt_gapok"),
            'cabang.kota_id','=','dt_gapok.kota_id'
        )
        ->leftJoin(
            DB::raw("(SELECT kota_id, COUNT(id) as jml_cabang FROM cabang GROUP BY kota_id) dt_cabang"),
            'cabang.kota_id','=','dt_cabang.kota_id'
        )
        ->where('cabang.id',$cabang_id)
        ->groupBy('cabang.kota_id')
        ->first();

        $data = [
            'stok' => Stok::selectRaw("SUM(IF(jenis = 'Keluar',harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', harga,0)) as harga_refund")->where('stok.tgl','>=',$tgl1)->where('stok.tgl','<=',$tgl2)->where('cabang_id',$cabang_id)->whereIn('jenis',['Keluar','Refund'])->groupBy('cabang_id')->first(),
            'varian' => PenjualanVarian::selectRaw("SUM(penjualan_varian.harga) as ttl_varian")->leftJoin('penjualan_kasir','penjualan_varian.penjualan_id','=','penjualan_kasir.id')->where('penjualan_varian.tgl','>=',$tgl1)->where('penjualan_varian.tgl','<=',$tgl2)->where('cabang_id',$cabang_id)->where('penjualan_kasir.void','!=',2)->groupBy('cabang_id')->first(),
            'biaya_oprational' => $biaya_oprational,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'cabang_id' => $cabang_id,
            'penjualan' => $penjualan,
            'barang_kebutuhan' => $barang_kebutuhan,
            // 'rusak' => Jurnal::selectRaw("SUM(debit) as ttl_debit")->where('buku_id',4)->where('akun_id',19)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('kota_id',$kota_id)->groupBy('kota_id')->first(),
            // 'penjualan_cabang' => Jurnal::selectRaw("SUM(debit) as ttl_debit")->where('buku_id',5)->where('akun_id',1)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('kota_id',$kota_id)->groupBy('kota_id')->first(),
            // 'gapok_crew' => Gapok::selectRaw("SUM(gapok) as ttl_gapok")->where('kota_id',$kota_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('kota_id')->first(),
            'gapok_crew' => $gapok_crew,
            'gapok_office' => GapokOffice::selectRaw("SUM(gapok_office.gapok) as ttl_gapok")->where('cabang_id',$cabang_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->groupBy('gapok_office.kota_id')->first(),
            'persen_office' => $persen_office,
            'persen_investor' => $persen_investor,
        ];
        return view('component.dt_jurnal_peroutlet',$data)->render();

    }

    public function getHppBahan(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $kota_id = $request->kota_id;
        $data = [
            'stok' => Stok::select('bahan.bahan')->selectRaw("SUM(IF(jenis = 'Keluar',stok.harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', stok.harga,0)) as harga_refund, SUM(debit) as ttl_debit, SUM(kredit) as ttl_kredit")->leftJoin('bahan','stok.bahan_id','bahan.id')->leftJoin('cabang','stok.cabang_id','=','cabang.id')->where('stok.tgl','>=',$tgl1)->where('stok.tgl','<=',$tgl2)->where('cabang.kota_id',$kota_id)->whereIn('jenis',['Keluar','Refund'])->groupBy('bahan.id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('component.hpp_bahan',$data)->render();
    }

    public function getHppSaos(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $kota_id = $request->kota_id;
        $data = [
            'varian' => PenjualanVarian::select('varian.nm_varian')->selectRaw("SUM(penjualan_varian.harga) as ttl_varian, SUM(penjualan_varian.qty) as ttl_qty")->leftJoin('varian','penjualan_varian.varian_id','=','varian.id')->leftJoin('penjualan_kasir','penjualan_varian.penjualan_id','=','penjualan_kasir.id')->leftJoin('cabang','penjualan_kasir.cabang_id','=','cabang.id')->where('penjualan_varian.tgl','>=',$tgl1)->where('penjualan_varian.tgl','<=',$tgl2)->where('cabang.kota_id',$kota_id)->where('penjualan_kasir.void','!=',2)->groupBy('penjualan_varian.varian_id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('component.hpp_varian',$data)->render();
    }

    public function getHppKebutuhan(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $kota_id = $request->kota_id;
        $data = [
            'kebutuhan' => Jurnal::select('barang_kebutuhan.nm_barang')->selectRaw("SUM(kredit) as ttl_kebutuhan, SUM(qty_kredit) as ttl_qty")->leftJoin('barang_kebutuhan','jurnal.barang_id','=','barang_kebutuhan.id')->where('kota_id',$kota_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->where('akun_id',14)->groupBy('jurnal.barang_id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('component.hpp_kebutuhan',$data)->render();
    }

    public function getDtPenjualan(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($bulan_tahun.'-01'));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kota_id = $request->kota_id;

        $data = [
            'title' => 'Laporan Penjualan',
            'penjualan' => PenjualanKasir::select('pembayaran.pembayaran')->selectRaw("SUM(jurnal.kredit) as total")->leftJoin('jurnal','penjualan_kasir.id','=','jurnal.transaksi_id')->leftJoin('pembayaran','penjualan_kasir.pembayaran_id','=','pembayaran.id')->leftJoin('cabang','penjualan_kasir.cabang_id','=','cabang.id')->where('jurnal.akun_id',2)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('cabang.kota_id',$kota_id)->where('penjualan_kasir.void','!=',2)->groupBy('penjualan_kasir.pembayaran_id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('component.dt_penjualan',$data)->render();
    }

    public function addBiayaOprasional(Request $request)
    {
        $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $data_jurnal [] = [
            'kd_gabungan' => $kd_gabungan,
            'buka_toko_id' => 0,
            'transaksi_id' => 0,
            'kota_id' => $request->kota_id,
            'cabang_id' => $request->cabang_id,
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
            'buka_toko_id' => 0,
            'transaksi_id' => 0,
            'kota_id' => $request->kota_id,
            'cabang_id' => $request->cabang_id,
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

        Jurnal::insert($data_jurnal);

        return true;

    }

    public function getBiayaOprasional(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($first_day));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kota_id = $request->kota_id;

        $akun_id = $request->akun_id;

        $data = [
            'title' => 'Laporan Biaya Oprasional',
            'biaya' => Jurnal::where('akun_id',$akun_id)->where('kota_id',$kota_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->with(['akun','cabang'])->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
            'oprasinoal' => AkunPengeluaran::where('jenis_akun_id',5)->get(),
        ];
        return view('page.dt_biaya_oprasional',$data);

    }

    public function getBiayaOprasionalGroup(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($first_day));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kota_id = $request->kota_id;

        $akun_id = $request->akun_id;

        $data = [
            'title' => 'Laporan Biaya Oprasional',
            'biaya' => Jurnal::select('jurnal.*')->selectRaw("SUM(debit) as ttl_debit")->where('akun_id',$akun_id)->where('kota_id',$kota_id)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->groupBy('cabang_id')->groupBy('tgl')->orderBy('tgl','ASC')->with(['akun','cabang'])->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('page.dt_biaya_oprasional_group',$data);

    }

    public function editBiayaOprasional(Request $request)
    {
        $dt_jurnal = Jurnal::where('kd_gabungan',$request->kd_gabungan)->get();

        foreach ($dt_jurnal as $d) {
            if($d->debit){
                Jurnal::where('id',$d->id)->update([
                    'tgl' => $request->tgl,
                    'akun_id' => $request->akun_id,
                    'debit' => $request->biaya,
                    'ket' => $request->ket,
                ]);
            }else{
                Jurnal::where('id',$d->id)->update([
                    'tgl' => $request->tgl,
                    'kredit' => $request->biaya,
                    'ket' => $request->ket,
                ]);
            }
        }

        return redirect()->back()->with('success','Data berhasil diedit');
    }

    public function deleteBiayaOprasional($kd_gabungan)
    {
        Jurnal::where('kd_gabungan',$kd_gabungan)->delete();

        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function getHargaPokokPenjualan(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($first_day));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kota_id = $request->kota_id;

        $akun_id = $request->akun_id;

        $biaya_bahan = Jurnal::selectRaw("bahan.bahan as nama_barang, SUM(debit) as jumlah, SUM(qty_debit) as qty")->leftJoin('bahan','jurnal.bahan_id','bahan.id')->where('jurnal.void',0)->where('jurnal.akun_id',13)->where('bahan_id','!=',0)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('jurnal.kota_id',$kota_id)->groupBy('bahan.id')->get();
        $biaya_varian = Jurnal::selectRaw("varian.nm_varian as nama_barang, SUM(jurnal.debit) as jumlah, SUM(jurnal.qty_debit) as qty")->leftJoin('varian','jurnal.varian_id','varian.id')->where('jurnal.void',0)->where('jurnal.akun_id',13)->where('varian_id','!=',0)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('jurnal.kota_id',$kota_id)->groupBy('varian.id')->get();
        $biaya_kebutuhan = Jurnal::selectRaw("barang_kebutuhan.nm_barang as nama_barang, SUM(jurnal.debit) as jumlah, SUM(jurnal.qty_debit) as qty")->leftJoin('barang_kebutuhan','jurnal.barang_id','barang_kebutuhan.id')->where('jurnal.void',0)->where('jurnal.akun_id',13)->where('barang_id','!=',0)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('jurnal.kota_id',$kota_id)->groupBy('barang_kebutuhan.id')->get();


        $data = [
            'title' => 'Laporan Biaya Oprasional',
            'biaya_bahan' => $biaya_bahan,
            'biaya_varian' => $biaya_varian,
            'biaya_kebutuhan' => $biaya_kebutuhan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];
        return view('page.dt_hpp',$data);

    }

    public function getNeraca(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($first_day));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $kota_id = $request->kota_id;

        $data = [
            'title' => 'Laporan Neraca',
            'neraca' => Jurnal::select('akun_pengeluaran.nm_akun','akun_pengeluaran.id')->selectRaw("SUM(jurnal.debit) as ttl_debit, SUM(jurnal.kredit) as ttl_kredit")->leftJoin('akun_pengeluaran','jurnal.akun_id','=','akun_pengeluaran.id')->whereIn('akun_pengeluaran.jenis_akun_id',[1,4])->where('jurnal.kota_id',$kota_id)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('jurnal.void',0)->groupBy('akun_pengeluaran.id')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
            
        ];
        return view('component.neraca',$data)->render();

    }

    public function saldoAwalPersediaan(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $data_kas = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;
        $kas_barang = $request->kas_barang;

        $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

        $month = date("m", strtotime($request->tgl1));
        $year = date("Y", strtotime($request->tgl1));
        // $cek_kas = Jurnal::whereMonth('tgl',$month)->whereYear('tgl',$year)->where('buku_id',3)->where('akun_id',1)->where('kota_id',$request->kota_id)->first();

        // if (!$cek_kas && $request->kas) {
        //     $data_jurnal [] = [
        //         'kd_gabungan' => $kd_gabungan,
        //         'buka_toko_id' => 0,
        //         'transaksi_id' => 0,
        //         'kota_id' => $request->kota_id,
        //         'cabang_id' => 0,
        //         'buku_id' => 3,
        //         'akun_id' => 1,
        //         'bahan_id' => 0,
        //         'barang_id' => 0,
        //         'varian_id' => 0,
        //         'debit' => $request->kas,
        //         'kredit' => 0,
        //         'qty_debit' => 0,
        //         'qty_kredit' => 0,
        //         'user_id' => $admin,
        //         'tgl' => $request->tgl1,
        //         'ket' => 'Saldo Awal Kas',
        //         'void' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ];
    
        //     $data_jurnal [] = [
        //         'kd_gabungan' => $kd_gabungan,
        //         'buka_toko_id' => 0,
        //         'transaksi_id' => 0,
        //         'kota_id' => $request->kota_id,
        //         'cabang_id' => 0,
        //         'buku_id' => 3,
        //         'akun_id' => 16,
        //         'bahan_id' => 0,
        //         'barang_id' => 0,
        //         'varian_id' => 0,
        //         'debit' => 0,
        //         'kredit' => $request->kas,
        //         'qty_debit' => 0,
        //         'qty_kredit' => 0,
        //         'user_id' => $admin,
        //         'tgl' => $request->tgl1,
        //         'ket' => 'Saldo Awal Kas',
        //         'void' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ];
        // }
        

        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                $dt_harga = HargaBahan::where('bahan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                
                $cek_barang = Jurnal::whereMonth('tgl',$month)->whereYear('tgl',$year)->where('buku_id',3)->where('akun_id',$jenis_barang)->where('kota_id',$request->kota_id)->where('bahan_id',$br_id)->first();
            }elseif($jenis_barang == 14){
                $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;

                $cek_barang = Jurnal::whereMonth('tgl',$month)->whereYear('tgl',$year)->where('buku_id',3)->where('akun_id',$jenis_barang)->where('kota_id',$request->kota_id)->where('barang_id',$br_id)->first();
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                $dt_harga = HargaVarian::where('varian_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            
                $cek_barang = Jurnal::whereMonth('tgl',$month)->whereYear('tgl',$year)->where('buku_id',3)->where('akun_id',$jenis_barang)->where('kota_id',$request->kota_id)->where('varian_id',$br_id)->first();
            }

            if(!$cek_barang){
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_id,
                    'cabang_id' => 0,
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
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_id,
                    'cabang_id' => 0,
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

                $data_kas [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'kota_id' => $request->kota_id,
                    'bahan_id' => $bahan_id,
                    'barang_id' => $barang_id,
                    'varian_id' => $varian_id,
                    'kas' => $kas_barang[$count],
                    'user_id' => $admin,
                    'tgl' => $request->tgl1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            
            
        }

        if(!empty($data_jurnal)){
            Jurnal::insert($data_jurnal);
        }

        if(!empty($data_kas)){
            KasBarang::insert($data_kas);
        }
        
        return true;
    }


    public function pembelianBarang(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;

        $total = $request->total;


        for($count = 0; $count<count($dt_barang); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));

            $data_barang = explode( "|", $dt_barang[$count]);

            $br_id = $data_barang[0];
            $jenis_barang = $data_barang[1];
            
            if($jenis_barang == 3){
                $bahan_id = $br_id;
                $barang_id = 0;
                $varian_id = 0;

                // $dt_harga = HargaBahan::where('bahan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                // $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }elseif($jenis_barang == 14){
                // $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                // $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                // $dt_harga = HargaVarian::where('varian_id',$br_id)->where('kota_id',$request->kota_id)->first();
                // $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }
            
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => 0,
                'buku_id' => 2,
                'akun_id' => $jenis_barang,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => $total[$count],
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
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => 0,
                'buku_id' => 2,
                'akun_id' => 1,
                'bahan_id' => $bahan_id,
                'barang_id' => $barang_id,
                'varian_id' => $varian_id,
                'debit' => 0,
                'kredit' => $total[$count],
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

        

        Jurnal::insert($data_jurnal);

        return true;
    }

    public function barangRusak(Request $request)
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

                $dt_harga = HargaBahan::where('bahan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }elseif($jenis_barang == 14){
                $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $bahan_id = 0;
                $barang_id = $br_id;
                $varian_id = 0;
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }else{
                $bahan_id = 0;
                $barang_id = 0;
                $varian_id = $br_id;

                $dt_harga = HargaVarian::where('varian_id',$br_id)->where('kota_id',$request->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }
            
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => 0,
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
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => 0,
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

        

        Jurnal::insert($data_jurnal);

        return true;
    }

    public function transferBarang(Request $request)
    {
        $admin = Auth::user()->id;

        $data_jurnal = [];

        $dt_barang = $request->barang_id;
        $qty = $request->qty;

        if($request->kota_id == $request->kota_transfer){
            return false;
        }else{

            for($count = 0; $count<count($dt_barang); $count++){
                $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));
    
                $data_barang = explode( "|", $dt_barang[$count]);
    
                $br_id = $data_barang[0];
                $jenis_barang = $data_barang[1];
                
                if($jenis_barang == 3){
                    $bahan_id = $br_id;
                    $barang_id = 0;
                    $varian_id = 0;
    
                    $dt_harga = HargaBahan::where('bahan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }elseif($jenis_barang == 14){
                    $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$br_id)->where('kota_id',$request->kota_id)->first();
                    $bahan_id = 0;
                    $barang_id = $br_id;
                    $varian_id = 0;
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }else{
                    $bahan_id = 0;
                    $barang_id = 0;
                    $varian_id = $br_id;
    
                    $dt_harga = HargaVarian::where('varian_id',$br_id)->where('kota_id',$request->kota_id)->first();
                    $harga_barang = $dt_harga ? $dt_harga->harga : 0;
                }
                
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_id,
                    'cabang_id' => 0,
                    'buku_id' => 5,
                    'akun_id' => 1,
                    'bahan_id' => $bahan_id,
                    'barang_id' => $barang_id,
                    'varian_id' => $varian_id,
                    'debit' => $qty[$count] * $harga_barang,
                    'kredit' => 0,
                    'qty_debit' => $qty[$count],
                    'qty_kredit' => 0,
                    'user_id' => $admin,
                    'tgl' => $request->tgl,
                    'ket' => 'Penjualan antar cabang',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
        
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_id,
                    'cabang_id' => 0,
                    'buku_id' => 5,
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
                    'ket' => 'Penjualan antar cabang',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
    
    
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_transfer,
                    'cabang_id' => 0,
                    'buku_id' => 5,
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
                    'ket' => 'Penjualan antar cabang',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
        
                $data_jurnal [] = [
                    'kd_gabungan' => $kd_gabungan,
                    'buka_toko_id' => 0,
                    'transaksi_id' => 0,
                    'kota_id' => $request->kota_transfer,
                    'cabang_id' => 0,
                    'buku_id' => 5,
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
                    'ket' => 'Penjualan antar cabang',
                    'void' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
    
            
    
            Jurnal::insert($data_jurnal);
    
            return true;

        }


        
    }

    public function dtStokBarang(Request $request)
    {
        // $bulan_tahun = $request->bulan_tahun;
        // $first_day = $bulan_tahun.'-01';

        // $last_day = date("Y-m-t", strtotime($bulan_tahun.'-01'));

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kota_id = $request->kota_id;

        $dt_bahan = Bahan::select('bahan.bahan','bahan.id')->selectRaw('dt_bahan.saldo_awal, dt_bahan.penjualan, dt_bahan.pembelian, dt_bahan.rusak, dt_bahan.pembelian2, dt_bahan.penjualan2, dt_bahan.pendapatan, dt_bahan.pengeluaran, dt_stok.pendapatan2, dt_stok.pendapatan3, dt_stok.ttl_debit, dt_stok.ttl_kredit, dt_stok_baku.stok_baku, dt_kas_barang.kas, dt_bahan.penjualan11')
        ->leftJoin(
            DB::raw("(SELECT bahan_id, SUM(IF(jurnal.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(buku_id = 1 OR buku_id = 3 OR buku_id = 5, kredit,0)) as pendapatan, SUM(IF(jurnal.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(buku_id = 2 OR buku_id = 5, debit, 0)) as pengeluaran, SUM(IF(jurnal.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal.buku_id = 3,qty_kredit,0)) as penjualan2, SUM(IF(jurnal.buku_id = 5,qty_kredit,0)) as penjualan11 FROM jurnal WHERE akun_id = 3 AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND kota_id = $kota_id GROUP BY bahan_id) dt_bahan"), 
                'bahan.id', '=', 'dt_bahan.bahan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT bahan_id, SUM(debit) AS ttl_debit, SUM(kredit) AS ttl_kredit, SUM(IF(jenis = 'Keluar',harga,0)) as pendapatan2, SUM(IF(jenis = 'Refund',harga,0)) as pendapatan3 FROM stok LEFT JOIN cabang ON stok.cabang_id = cabang.id WHERE cabang.kota_id = $kota_id AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND jenis IN('Refund','Keluar') GROUP BY bahan_id ) dt_stok"), 
                'bahan.id', '=', 'dt_stok.bahan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT bahan_id, stok_baku FROM harga_bahan WHERE kota_id = $kota_id) dt_stok_baku"),
            'bahan.id','=','dt_stok_baku.bahan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT bahan_id, kas FROM kas_barang WHERE kas_barang.kota_id = $kota_id AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND bahan_id != 0 GROUP BY bahan_id) dt_kas_barang"),
            'bahan.id','=','dt_kas_barang.bahan_id'
        )
        ->where('aktif','Y')->orderBy('bahan.possition','ASC')->get();

        $dt_varian = Varian::select('varian.nm_varian','varian.id')->selectRaw('dt_varian.saldo_awal, dt_varian.penjualan, dt_varian.pembelian, dt_varian.rusak, dt_varian.pembelian2, dt_varian.penjualan2, dt_varian.pendapatan, dt_varian.pengeluaran, dt_penjualan.qty_varian, dt_penjualan.pendapatan2, dt_stok_baku.stok_baku, dt_kas_barang.kas, dt_varian.penjualan11')
        ->leftJoin(
            DB::raw("(SELECT varian_id, SUM(IF(jurnal.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(buku_id = 1 OR buku_id = 3 OR buku_id = 5, kredit,0)) as pendapatan,  SUM(IF(jurnal.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(buku_id = 2 OR buku_id = 5, debit, 0)) as pengeluaran, SUM(IF(jurnal.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal.buku_id = 3,qty_kredit,0)) as penjualan2, SUM(IF(jurnal.buku_id = 5,qty_kredit,0)) as penjualan11 FROM jurnal WHERE akun_id = 15 AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND kota_id = $kota_id GROUP BY varian_id) dt_varian"), 
                'varian.id', '=', 'dt_varian.varian_id'
        )
        ->leftJoin(
            DB::raw("(SELECT varian_id, SUM(penjualan_varian.qty) as qty_varian, SUM(penjualan_varian.harga) as pendapatan2 FROM penjualan_varian LEFT JOIN penjualan_kasir ON penjualan_varian.penjualan_id = penjualan_kasir.id LEFT JOIN cabang ON penjualan_kasir.cabang_id = cabang.id WHERE cabang.kota_id = $kota_id AND penjualan_kasir.void != 2 AND penjualan_varian.tgl >= '$tgl1' AND penjualan_varian.tgl <= '$tgl2' GROUP BY penjualan_varian.varian_id) dt_penjualan"), 
                'varian.id', '=', 'dt_penjualan.varian_id'
        )
        ->leftJoin(
            DB::raw("(SELECT varian_id, stok_baku FROM harga_varian WHERE kota_id = $kota_id) dt_stok_baku"),
            'varian.id','=','dt_stok_baku.varian_id'
        )
        ->leftJoin(
            DB::raw("(SELECT varian_id, kas FROM kas_barang WHERE kas_barang.kota_id = $kota_id AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND varian_id != 0 GROUP BY varian_id) dt_kas_barang"),
            'varian.id','=','dt_kas_barang.varian_id'
        )
        ->where('kategori_varian_id',1)->get();

        $dt_kebutuhan = Jurnal::selectRaw("barang_id as id, barang_kebutuhan.nm_barang as nama, SUM(IF(jurnal.buku_id = 3,qty_debit,0)) as saldo_awal, SUM(IF(buku_id = 1 OR buku_id = 3 OR buku_id = 5, kredit, 0)) as pendapatan, SUM(IF(jurnal.buku_id = 1,qty_kredit,0)) as penjualan, SUM(IF(buku_id = 2 OR buku_id = 5, debit, 0)) as pengeluaran, SUM(IF(jurnal.buku_id = 2,qty_debit,0)) as pembelian, SUM(IF(jurnal.buku_id = 4,qty_kredit,0)) as rusak, SUM(IF(jurnal.buku_id = 5,qty_debit,0)) as pembelian2, SUM(IF(jurnal.buku_id = 3,qty_kredit,0)) as penjualan2, dt_stok_baku.stok_baku, dt_kas_barang.kas, SUM(IF(jurnal.buku_id = 5,qty_kredit,0)) as penjualan11")->leftJoin('barang_kebutuhan','jurnal.barang_id','=','barang_kebutuhan.id')
        ->leftJoin(
            DB::raw("(SELECT barang_kebutuhan_id, stok_baku FROM harga_kebutuhan WHERE kota_id = $kota_id) dt_stok_baku"),
            'jurnal.barang_id','=','dt_stok_baku.barang_kebutuhan_id'
        )
        ->leftJoin(
            DB::raw("(SELECT barang_id as id_barang, kas FROM kas_barang WHERE kas_barang.kota_id = $kota_id AND tgl >= '$tgl1' AND tgl <= '$tgl2' AND barang_id != 0 GROUP BY barang_id) dt_kas_barang"),
            'jurnal.barang_id','=','dt_kas_barang.id_barang'
        )
        ->where('jurnal.akun_id',14)->where('jurnal.tgl','>=',$tgl1)->where('jurnal.tgl','<=',$tgl2)->where('jurnal.kota_id',$kota_id)->groupBy('barang_id')->get();
        
        $data= [
            'dt_bahan' => $dt_bahan,
            'dt_varian' => $dt_varian,
            'dt_kebutuhan' => $dt_kebutuhan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kota_id' => $kota_id,
        ];

        return view('component.dt_stok_barang',$data)->render();
    
    }

    public function jurnalBarangKebutuhan(Request $request)
    {

        $admin = Auth::user()->id;

        $data_jurnal = [];
        $qty = $request->qty;
        $barang_id = $request->barang_id;


        for($count = 0; $count<count($barang_id); $count++){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));
            
            $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$barang_id[$count])->where('kota_id',$request->kota_id)->first();

            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => $request->cabang_id,
                'buku_id' => 1,
                'akun_id' => 13,
                'bahan_id' => 0,
                'barang_id' => $barang_id[$count],
                'varian_id' => 0,
                'debit' => $qty[$count] * $dt_harga->harga,
                'kredit' => 0,
                'qty_debit' => $qty[$count],
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pengeluaran Barang Kebutuhan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $request->kota_id,
                'cabang_id' => $request->cabang_id,
                'buku_id' => 1,
                'akun_id' => 14,
                'bahan_id' => 0,
                'barang_id' => $barang_id[$count],
                'varian_id' => 0,
                'debit' => 0,
                'kredit' => $qty[$count] * $dt_harga->harga,
                'qty_debit' => 0,
                'qty_kredit' => $qty[$count],
                'user_id' => $admin,
                'tgl' => $request->tgl,
                'ket' => 'Pengeluaran Barang Kebutuhan',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        

        Jurnal::insert($data_jurnal);

        return true;
        
    }

    public function updateHargaStok()
    {
        $dt_stok = Stok::select('cabang.kota_id','stok.id','stok.bahan_id','stok.debit','stok.kredit')->leftJoin('cabang','stok.cabang_id','=','cabang.id')->where('tgl','>=','2023-04-01')->get();
        
        foreach($dt_stok as $d){
            $dt_harga = HargaBahan::where('bahan_id',$d->bahan_id)->where('kota_id',$d->kota_id)->first();
            Stok::where('id',$d->id)->update([
                'harga' => ($d->debit + $d->kredit) * ($dt_harga ? $dt_harga->harga : 0)
            ]);
        }

        return 'yes';
    }

    public function updateHargaVarian()
    {
        
        $dt_penjualan = PenjualanKasir::select('cabang.kota_id','penjualan_kasir.id')->selectRaw("COUNT(penjualan_varian.id) as jml_varian, GROUP_CONCAT(DISTINCT penjualan_varian.varian_id SEPARATOR ', ') as varian_id, GROUP_CONCAT(DISTINCT penjualan_varian.id SEPARATOR ', ') as penjualan_varian_id")->leftJoin('produk','penjualan_kasir.produk_id','=','produk.id')->leftJoin('penjualan_varian','penjualan_kasir.id','=','penjualan_varian.penjualan_id')->leftJoin('cabang','penjualan_kasir.cabang_id','=','cabang.id')->where('penjualan_kasir.tgl','>=','2023-04-01')->whereIn('produk.kategori_id',[1,2])->groupBy('penjualan_kasir.id')->get();

        foreach($dt_penjualan as $d){
            
            if($d->jml_varian > 1){
                $qty = 30 / $d->jml_varian;
                $varian_id = explode( ",", $d->varian_id);
                $penjualan_varian_id = explode( ",", $d->penjualan_varian_id);

                for($count = 0; $count<count($varian_id); $count++){
                    $dt_harga = HargaVarian::where('varian_id',$varian_id[$count])->where('kota_id',$d->kota_id)->first();

                    PenjualanVarian::where('id',$penjualan_varian_id[$count])->update([
                        'harga' => $qty * ($dt_harga ? $dt_harga->harga : 0),
                        'qty' => $qty
                    ]);
                }
                
            }else{
                
                $dt_harga = HargaVarian::where('varian_id',$d->varian_id)->where('kota_id',$d->kota_id)->first();
                $qty = 30;
                PenjualanVarian::where('id',$d->penjualan_varian_id)->update([
                    'harga' => $qty * ($dt_harga ? $dt_harga->harga : 0),
                    'qty' => $qty
                ]);
            }

        }

        return 'yes';

    }

    public function inputPokok()
    {
        $admin = 1;
        $data_jurnal = [];

        $tgl = date('Y-m-d');

        $dt_harga = HargaPengeluaran::with('cabang')->get();

        

        foreach($dt_harga as $d){
            $kd_gabungan = 'INV'.date('dmy').strtoupper(Str::random(5));
        
            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $d->cabang->kota_id,
                'cabang_id' => $d->cabang_id,
                'buku_id' => 2,
                'akun_id' => $d->akun_id,
                'bahan_id' => 0,
                'barang_id' => 0,
                'varian_id' => 0,
                'debit' => $d->harga,
                'kredit' => 0,
                'qty_debit' => 0,
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $tgl,
                'ket' => 'Biaya Pokok',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $data_jurnal [] = [
                'kd_gabungan' => $kd_gabungan,
                'buka_toko_id' => 0,
                'transaksi_id' => 0,
                'kota_id' => $d->cabang->kota_id,
                'cabang_id' => $d->cabang_id,
                'buku_id' => 2,
                'akun_id' => 1,
                'bahan_id' => 0,
                'barang_id' => 0,
                'varian_id' => 0,
                'debit' => 0,
                'kredit' => $d->harga,
                'qty_debit' => 0,
                'qty_kredit' => 0,
                'user_id' => $admin,
                'tgl' => $tgl,
                'ket' => 'Biaya Pokok',
                'void' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];                                              
        }


        Jurnal::insert($data_jurnal);

        $dt_karyawan = Karyawan::where('gapok','!=',0)->get();

        $dt_karyawan_office = KaryawanOffice::where('gapok','!=',0)->where('aktif',1)->with(['karyawanOfficeKota'])->get();

        // dd($dt_karyawan_office);

        if(date('m-d') == '03-28'){

        }else{
            if(date('d') != 31){
                foreach($dt_karyawan as $d){
                    Gapok::create([
                        'karyawan_id' => $d->id,
                        'gapok' => $d->gapok/30,
                        'kota_id' => $d->kota_id,
                        'tgl' => $tgl,
                    ]);
                }
    
                foreach($dt_karyawan_office as $d){
                    $jumlah = count($d->karyawanOfficeKota);
                    foreach($d->karyawanOfficeKota as $dk){
                        GapokOffice::create([
                            'karyawan_id' => $d->id,
                            'gapok' => ($d->gapok/30)/$jumlah,
                            'cabang_id' => $dk->cabang_id,
                            'tgl' => $tgl,
                        ]);
                    }
                    
                }
            }
            
            
        }

        return true;
    }

    public function editInfaq()
    {
        $jurnal = Jurnal::select('jurnal.id','jurnal.debit','jurnal.kredit','penjualan_kasir.qty')->leftJoin('penjualan_kasir','jurnal.transaksi_id','=','penjualan_kasir.id')->where('jurnal.ket','Infaq')->get();

        foreach ($jurnal as $d) {
            if($d->debit != 0){
                Jurnal::where('id',$d->id)->update([
                    'debit' => 200 * $d->qty
                ]);
            }

            if($d->kredit != 0){
                Jurnal::where('id',$d->id)->update([
                    'kredit' => 200 * $d->qty
                ]);
            }
        }

        return 'Ya';
    }

    public function editDll()
    {
        $jurnal = Jurnal::select('jurnal.id','jurnal.debit','jurnal.kredit','penjualan_kasir.qty')->leftJoin('penjualan_kasir','jurnal.transaksi_id','=','penjualan_kasir.id')->where('jurnal.ket','Beban Dll')->get();

        foreach ($jurnal as $d) {
            if($d->debit != 0){
                Jurnal::where('id',$d->id)->update([
                    'debit' => 1100 * $d->qty
                ]);
            }

            if($d->kredit != 0){
                Jurnal::where('id',$d->id)->update([
                    'kredit' => 1100 * $d->qty
                ]);
            }
        }

        return 'Ya';
    }

    public function getSaldoAwal(Request $request)
    {

        $month = date("m", strtotime($request->tgl1));

        $year = date("Y", strtotime($request->tgl1));

        if ($request->jenis == 1) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('bahan.bahan as nama_barang, dt_kas.kas_barang_id, dt_kas.kas')->leftJoin('bahan','jurnal.bahan_id','=','bahan.id')
            ->leftJoin(
                DB::raw("(SELECT bahan_id as bahan_id_kas, id as kas_barang_id, kas FROM kas_barang WHERE MONTH(tgl) = $month AND YEAR(tgl) = $year AND kota_id = $request->kota_id GROUP BY kas_barang.bahan_id ) dt_kas"), 
                    'jurnal.bahan_id', '=', 'dt_kas.bahan_id_kas'
            )
            ->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('kota_id',$request->kota_id)->where('bahan_id',$request->id_barang)->where('akun_id',3)->where('buku_id',3)->first()->toJson();
        } elseif($request->jenis == 2) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('varian.nm_varian as nama_barang, dt_kas.kas_barang_id, dt_kas.kas')->leftJoin('varian','jurnal.varian_id','=','varian.id')
            ->leftJoin(
                DB::raw("(SELECT varian_id as varian_id_kas, id as kas_barang_id, kas FROM kas_barang WHERE MONTH(tgl) = $month AND YEAR(tgl) = $year AND kota_id = $request->kota_id GROUP BY kas_barang.varian_id ) dt_kas"), 
                    'jurnal.varian_id', '=', 'dt_kas.varian_id_kas'
            )
            ->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('kota_id',$request->kota_id)->where('varian_id',$request->id_barang)->where('akun_id',15)->where('buku_id',3)->first()->toJson();
        }else{
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang, dt_kas.kas_barang_id, dt_kas.kas')->leftJoin('barang_kebutuhan','jurnal.barang_id','=','barang_kebutuhan.id')
            ->leftJoin(
                DB::raw("(SELECT barang_id as barang_id_kas, id as kas_barang_id, kas FROM kas_barang WHERE MONTH(tgl) = $month AND YEAR(tgl) = $year AND kota_id = $request->kota_id GROUP BY kas_barang.barang_id ) dt_kas"), 
                    'jurnal.barang_id', '=', 'dt_kas.barang_id_kas'
            )
            ->whereMonth('tgl',$month)->whereYear('tgl',$year)->where('kota_id',$request->kota_id)->where('barang_id',$request->id_barang)->where('akun_id',14)->where('buku_id',3)->first()->toJson();
        }
        
        return $dt_jurnal;
        
    }

    public function editSaldoAwal(Request $request)
    {
        $dt_jurnal = Jurnal::where('kd_gabungan',$request->kd_gabungan)->get();

        if($request->jenis == 1){
            

            $dt_harga = HargaBahan::where('bahan_id',$dt_jurnal[0]->bahan_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }elseif($request->jenis == 3){
            $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$dt_jurnal[0]->barang_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
            
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }else{
            

            $dt_harga = HargaVarian::where('varian_id',$dt_jurnal[0]->varian_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
            $harga_barang = $dt_harga ? $dt_harga->harga : 0;
        }

        foreach($dt_jurnal as $d){
            if ($d->akun_id == 16) {
                Jurnal::where('id',$d->id)->update([
                    'kredit' => $harga_barang * $request->qty,
                    'qty_kredit' => $request->qty,
                ]);
            } else {
                Jurnal::where('id',$d->id)->update([
                    'debit' => $harga_barang * $request->qty,
                    'qty_debit' => $request->qty,
                ]);
            }
            
        }

        $cek_kas = KasBarang::where('kd_gabungan',$request->kd_gabungan)->first();

        if($cek_kas){
            KasBarang::where('kd_gabungan',$request->kd_gabungan)->update([
                'kas' => $request->kas,
                'user_id' => Auth::user()->id,
            ]);
        }else{
            KasBarang::create([
                'kd_gabungan' => $request->kd_gabungan,
                'kota_id' => $dt_jurnal[0]->kota_id,
                'bahan_id' => $dt_jurnal[0]->bahan_id,
                'varian_id' => $dt_jurnal[0]->varian_id,
                'barang_id' => $dt_jurnal[0]->barang_id,
                'kas' => $request->kas,
                'tgl' => $dt_jurnal[0]->tgl,
                'user_id' => Auth::user()->id,
            ]);
        }

        return true;
    }

    public function getStokMasuk(Request $request)
    {


        if ($request->jenis == 1) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal.bahan_id','=','bahan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('bahan_id',$request->id_barang)->where('akun_id',3)->whereIn('buku_id',[2,5])->get();
        } elseif($request->jenis == 2) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal.varian_id','=','varian.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('varian_id',$request->id_barang)->where('akun_id',15)->whereIn('buku_id',[2,5])->get();
        }else{
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal.barang_id','=','barang_kebutuhan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('barang_id',$request->id_barang)->where('akun_id',14)->whereIn('buku_id',[2,5])->get();
        }
        
        return view('component.edit_stok_masuk',['dt_jurnal' => $dt_jurnal, 'jenis' => $request->jenis])->render();
        
    }

    public function editStokMasuk(Request $request)
    {
        $kd_gabungan = $request->kd_gabungan;

        $jenis = $request->jenis;

        $qty = $request->qty;

        $tgl = $request->tgl;

        for($count = 0; $count<count($kd_gabungan); $count++){

            $dt_jurnal = Jurnal::where('kd_gabungan',$kd_gabungan[$count])->get();

            if($jenis[$count] == 1){
                $dt_harga = HargaBahan::where('bahan_id',$dt_jurnal[0]->bahan_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }elseif($jenis[$count] == 3){
                $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$dt_jurnal[0]->barang_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }else{
                $dt_harga = HargaVarian::where('varian_id',$dt_jurnal[0]->varian_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }

            foreach($dt_jurnal as $d){
                if ($d->kredit !=0) {
                    Jurnal::where('id',$d->id)->update([
                        'kredit' => $harga_barang * $qty[$count],
                        'qty_kredit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                } else {
                    Jurnal::where('id',$d->id)->update([
                        'debit' => $harga_barang * $qty[$count],
                        'qty_debit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                }
                
            }

        }

        

        return true;
    }

    public function getStokRusak(Request $request)
    {


        if ($request->jenis == 1) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('bahan.bahan as nama_barang')->leftJoin('bahan','jurnal.bahan_id','=','bahan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('bahan_id',$request->id_barang)->where('akun_id',3)->where('buku_id',4)->get();
        } elseif($request->jenis == 2) {
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('varian.nm_varian as nama_barang')->leftJoin('varian','jurnal.varian_id','=','varian.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('varian_id',$request->id_barang)->where('akun_id',15)->where('buku_id',4)->get();
        }else{
            $dt_jurnal = Jurnal::select('jurnal.*')->selectRaw('barang_kebutuhan.nm_barang as nama_barang')->leftJoin('barang_kebutuhan','jurnal.barang_id','=','barang_kebutuhan.id')->where('tgl','>=',$request->tgl1)->where('tgl','<=',$request->tgl2)->where('kota_id',$request->kota_id)->where('barang_id',$request->id_barang)->where('akun_id',14)->where('buku_id',4)->get();
        }
        
        return view('component.edit_stok_rusak',['dt_jurnal' => $dt_jurnal, 'jenis' => $request->jenis])->render();
        
    }


    public function editStokRusak(Request $request)
    {
        $kd_gabungan = $request->kd_gabungan;

        $jenis = $request->jenis;

        $qty = $request->qty;

        $tgl = $request->tgl;

        for($count = 0; $count<count($kd_gabungan); $count++){

            $dt_jurnal = Jurnal::where('kd_gabungan',$kd_gabungan[$count])->get();

            if($jenis[$count] == 1){
                $dt_harga = HargaBahan::where('bahan_id',$dt_jurnal[0]->bahan_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }elseif($jenis[$count] == 3){
                $dt_harga = HargaKebutuhan::where('barang_kebutuhan_id',$dt_jurnal[0]->barang_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }else{
                $dt_harga = HargaVarian::where('varian_id',$dt_jurnal[0]->varian_id)->where('kota_id',$dt_jurnal[0]->kota_id)->first();
                $harga_barang = $dt_harga ? $dt_harga->harga : 0;
            }

            foreach($dt_jurnal as $d){
                if ($d->akun_id == 19) {
                    Jurnal::where('id',$d->id)->update([
                        'debit' => $harga_barang * $qty[$count],
                        'qty_debit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                } else {
                    Jurnal::where('id',$d->id)->update([
                        'kredit' => $harga_barang * $qty[$count],
                        'qty_kredit' => $qty[$count],
                        'tgl' => $tgl[$count],
                    ]);
                }
                
            }

        }

        return true;
    }

    public function editBebanDll()
    {
        $dt_jurnal = Jurnal::where('ket','Beban Dll')->where('created_at','<=','2023-05-05 22:40:00')->get();
    
        foreach($dt_jurnal as $j){
            if($j->debit){
                $qty = $j->debit / 1100;
                $nominal_baru = $qty * 2000;

                Jurnal::where('id',$j->id)->update([
                    'debit' => $nominal_baru
                ]);

            }else{
                $qty = $j->kredit / 1100;
                $nominal_baru = $qty * 2000;

                Jurnal::where('id',$j->id)->update([
                    'kredit' => $nominal_baru
                ]);
            }
        }

        return 'ya';

    }

    public function deletePokok()
    {
        $jurnal = Jurnal::where('ket','Biaya Pokok')->where('akun_id','!=',1)->where('akun_id','!=',5)->where('akun_id','!=',6)->get();
        
        $kd_gabungan = [];
        foreach($jurnal as $j){
            

            $kd_gabungan [] = $j->kd_gabungan;
        }

        Jurnal::whereIn('kd_gabungan',$kd_gabungan)->delete();
        return 'ya';
    }


}
