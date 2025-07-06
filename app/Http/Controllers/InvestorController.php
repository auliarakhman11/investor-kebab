<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\Gapok;
use App\Models\GapokOffice;
use App\Models\Investor;
use App\Models\InvoiceKasir;
use App\Models\Jurnal;
use App\Models\karyawanOfficeKota;
use App\Models\PenjualanGaji;
use App\Models\PenjualanGajiOffice;
use App\Models\PenjualanInvestor;
use App\Models\PenjualanKasir;
use App\Models\PenjualanVarian;
use App\Models\PersenInvestor;
use App\Models\Stok;
use App\Models\ViewJurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestorController extends Controller
{
    public function index()
    {

        // $data_user = PersenInvestor::where('investor_id',Auth::user()->id)->get();
        // $dt_akses = [];
        // foreach($data_user as $da){

        //         $dt_akses [] = $da->cabang_id;

        // }


        $data = [
            'title' => 'Investor',
            'cabang' => Cabang::select('cabang.*')->leftJoin('persen_investor', 'cabang.id', '=', 'persen_investor.cabang_id')->where('investor_id', Auth::user()->id)->get(),
        ];
        return view('page.investor', $data);
    }

    // public function dtJurnal2(Request $request)
    // {

    //     $data_user = PersenInvestor::where('investor_id', Auth::user()->id)->get();
    //     $dt_akses = [];
    //     foreach ($data_user as $da) {

    //         $dt_akses[] = $da->cabang_id;
    //     }

    //     $akses_cabang = join(",", $dt_akses);

    //     $tgl1 = $request->tgl1;
    //     $tgl2 = $request->tgl2;


    //     $biaya_oprational = AkunPengeluaran::select('akun_pengeluaran.id', 'nm_akun', 'jenis_akun_id')->selectRaw('dt_jurnal.ttl_debit')->leftJoin(
    //         DB::raw("(SELECT akun_id, SUM(debit) as ttl_debit FROM jurnal WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND cabang_id IN($akses_cabang) AND void = 0 GROUP BY akun_id) dt_jurnal"),
    //         'akun_pengeluaran.id',
    //         '=',
    //         'dt_jurnal.akun_id'
    //     )->whereIn('jenis_akun_id', [5, 3])->get();
    //     // $penjualan = PenjualanKasir::selectRaw('SUM(qty * harga_normal) as tot_penjualan')->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->whereIn('penjualan_kasir.cabang_id',$dt_akses)->where('void','!=',2)->first();

    //     // $barang_kebutuhan = Jurnal::selectRaw("SUM(kredit) as ttl_kebutuhan")->whereIn('cabang_id',$dt_akses)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->where('void',0)->where('akun_id',14)->first();


    //     // $dt_gaji_persen_office = karyawanOfficeKota::select('karyawan_office_kota.cabang_id')->selectRaw("dt_penjualan.ttl_penjualan, (IF(SUM(karyawan_office.persen) > 0, SUM(karyawan_office.persen) * dt_penjualan.ttl_penjualan / 100,0)) as ttl_gaji_persen")
    //     // ->leftJoin('karyawan_office','karyawan_office_kota.karyawan_id','=','karyawan_office.id')
    //     // ->leftJoin(
    //     //     DB::raw("(SELECT cabang_id, SUM(qty * harga_normal) as ttl_penjualan FROM penjualan_kasir WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND penjualan_kasir.void !=2 GROUP BY cabang_id) dt_penjualan"),
    //     //     'karyawan_office_kota.cabang_id','=','dt_penjualan.cabang_id'
    //     // )
    //     // ->whereIn('karyawan_office_kota.cabang_id',$dt_akses)
    //     // ->groupBy('karyawan_office_kota.cabang_id')
    //     // ->get();

    //     // $persen_office = 0;


    //     // foreach ($dt_gaji_persen_office as $d) {
    //     //     $persen_office += $d->ttl_gaji_persen;
    //     // }

    //     // $dt_gapok_crew = Cabang::selectRaw("IF(dt_cabang.jml_cabang > 0 AND dt_gapok.jml_gapok > 0 , dt_gapok.jml_gapok / dt_cabang.jml_cabang,0) as ttl_gapok")
    //     // ->leftJoin(
    //     //     DB::raw("(SELECT kota_id, SUM(gapok) as jml_gapok FROM gapok WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY kota_id) dt_gapok"),
    //     //     'cabang.kota_id','=','dt_gapok.kota_id'
    //     // )
    //     // ->leftJoin(
    //     //     DB::raw("(SELECT kota_id, COUNT(id) as jml_cabang FROM cabang GROUP BY kota_id) dt_cabang"),
    //     //     'cabang.kota_id','=','dt_cabang.kota_id'
    //     // )
    //     // ->whereIn('cabang.id',$dt_akses)
    //     // ->groupBy('cabang.id')
    //     // ->get();

    //     // $gapok_crew = 0;
    //     // foreach ($dt_gapok_crew as $d) {
    //     //     $gapok_crew += $d->ttl_gapok;
    //     // }

    //     // $persen_investor = PersenInvestor::selectRaw("IF(dt_laba.ttl_laba > 0 AND persen_investor.persen > 0, (persen_investor.persen * dt_laba.ttl_laba)/100,0) AS tot_investor")
    //     // ->leftJoin(
    //     //     DB::raw("(SELECT id, SUM(laba_rugi) AS ttl_laba FROM view_jurnal WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY id) dt_laba"),
    //     //     'persen_investor.cabang_id','=','dt_laba.id'
    //     // )
    //     // ->where('investor_id',Auth::user()->id)->get();

    //     // $ttl_persen_investor = 0;

    //     // foreach($persen_investor as $d){
    //     //     $ttl_persen_investor += $d->tot_investor;
    //     // }

    //     $investor_id = Auth::user()->id;

    //     $dt_jurnal = ViewJurnal::selectRaw("SUM(laba_rugi) as sum_laba, SUM(ttl_stok) as sum_stok, SUM(ttl_varian) as sum_varian, SUM(ttl_barang_kebutuhan) as sum_kebutuhan, SUM(ttl_penjualan) as sum_penjualan, SUM(ttl_gapok_office + ttl_persen_crew + ttl_persen_office + ttl_gapok_crew) as sum_gaji, SUM(ttl_investor) as sum_investor, SUM(ttl_biaya_oprasional) as sum_biaya, dt_investor.persen, SUM(ttl_rusak) as sum_rusak, SUM(ttl_penjualan_cabang) as sum_penjualan_cabang, SUM(ttl_gapok_crew) as sum_gapok_crew, SUM(ttl_gapok_office) as sum_gapok_office, SUM(ttl_persen_crew) as sum_persen_crew, SUM(ttl_persen_office) as sum_persen_office")
    //         ->leftJoin(
    //             DB::raw("(SELECT cabang_id, persen FROM persen_investor where investor_id = $investor_id ) dt_investor"),
    //             'view_jurnal.id',
    //             '=',
    //             'dt_investor.cabang_id'
    //         )
    //         ->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->whereIn('id', $dt_akses)->groupBy('cabang_id')->get();

    //     $sum_laba = 0;
    //     $sum_bahan = 0;
    //     $sum_biaya = 0;
    //     $sum_gaji = 0;
    //     $sum_investor = 0;
    //     $sum_penjualan = 0;
    //     $sum_penjualan_antar_cabang = 0;

    //     $sum_varian = 0;
    //     $sum_kebutuhan = 0;

    //     $sum_gapok_crew = 0;
    //     $sum_gapok_office = 0;
    //     $sum_persen_crew = 0;
    //     $sum_persen_office = 0;

    //     foreach ($dt_jurnal as $d) {
    //         $sum_laba += $d->sum_laba;
    //         $sum_bahan += $d->sum_stok;
    //         $sum_biaya += $d->sum_biaya;
    //         $sum_gaji += $d->sum_gaji;
    //         $sum_investor += $d->sum_laba && $d->persen ? $d->sum_laba * $d->persen / 100 : 0;
    //         $sum_penjualan += $d->sum_penjualan;
    //         $sum_penjualan_antar_cabang += $d->sum_penjualan_cabang;

    //         $sum_varian += $d->sum_varian;
    //         $sum_kebutuhan += $d->sum_kebutuhan;

    //         $sum_gapok_crew += $d->sum_gapok_crew;
    //         $sum_gapok_office += $d->sum_gapok_office;
    //         $sum_persen_crew += $d->sum_persen_crew;
    //         $sum_persen_office += $d->sum_persen_office;
    //     }

    //     $data = [
    //         // 'stok' => Stok::selectRaw("SUM(IF(jenis = 'Keluar',harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', harga,0)) as harga_refund")->where('stok.tgl','>=',$tgl1)->where('stok.tgl','<=',$tgl2)->whereIn('stok.cabang_id',$dt_akses)->whereIn('jenis',['Keluar','Refund'])->first(),
    //         // 'varian' => PenjualanVarian::selectRaw("SUM(penjualan_varian.harga) as ttl_varian")->leftJoin('penjualan_kasir','penjualan_varian.penjualan_id','=','penjualan_kasir.id')->where('penjualan_varian.tgl','>=',$tgl1)->where('penjualan_varian.tgl','<=',$tgl2)->whereIn('penjualan_kasir.cabang_id',$dt_akses)->where('penjualan_kasir.void','!=',2)->first(),
    //         'biaya_oprational' => $biaya_oprational,
    //         'tgl1' => $tgl1,
    //         'tgl2' => $tgl2,
    //         // 'penjualan' => $penjualan,
    //         // 'barang_kebutuhan' => $barang_kebutuhan,
    //         // 'gapok_crew' => $gapok_crew ? $gapok_crew : 0,
    //         // 'gapok_office' => GapokOffice::selectRaw("SUM(gapok_office.gapok) as ttl_gapok")->whereIn('gapok_office.cabang_id',$dt_akses)->where('tgl','>=',$tgl1)->where('tgl','<=',$tgl2)->first(),
    //         // 'persen_office' => $persen_office,
    //         // // 'persen_investor' => $persen_investor,
    //         // 'ttl_persen_investor' => $ttl_persen_investor,

    //         'sum_laba' => $sum_laba,
    //         'sum_bahan' => $sum_bahan,
    //         'sum_biaya' => $sum_biaya,
    //         'sum_gaji' => $sum_gaji,
    //         'sum_investor' => $sum_investor,
    //         'sum_penjualan' => $sum_penjualan,
    //         'sum_penjualan_antar_cabang' => $sum_penjualan_antar_cabang,
    //         'sum_gapok_crew' => $sum_gapok_crew,
    //         'sum_gapok_office' => $sum_gapok_office,
    //         'sum_persen_crew' => $sum_persen_crew,
    //         'sum_persen_office' => $sum_persen_office,

    //         'sum_varian' => $sum_varian,
    //         'sum_kebutuhan' => $sum_kebutuhan,

    //     ];
    //     return view('component.dt_jurnal', $data)->render();
    // }

    public function dtJurnal(Request $request)
    {

        // $data_perhitungan = Investor::select('investor.nm_investor','investor.id')->selectRaw(" SUM(persenan) AS ttl_persenan, SUM(tot_laba) as jml_laba")
        // ->leftJoin(
        //     DB::raw("(SELECT penjualan_investor.cabang_id, penjualan_investor.tgl, penjualan_investor.investor_id, (SUM(dt_laba.t_laba) * penjualan_investor.persen / 100) AS persenan, SUM(dt_laba.t_laba) as tot_laba FROM penjualan_investor 
        //     LEFT JOIN ( SELECT view_jurnal.id, SUM(laba_rugi) as t_laba, view_jurnal.tgl FROM view_jurnal WHERE view_jurnal.tgl >= '$request->tgl1' AND view_jurnal.tgl <= '$request->tgl2' GROUP BY view_jurnal.id) dt_laba ON penjualan_investor.cabang_id = dt_laba.id AND penjualan_investor.tgl = dt_laba.tgl
        //     WHERE penjualan_investor.tgl >= '$request->tgl1' AND penjualan_investor.tgl <= '$request->tgl2' GROUP BY penjualan_investor.investor_id, penjualan_investor.tgl, penjualan_investor.cabang_id) dt_investor"),
        //     'investor.id','=','dt_investor.investor_id'
        // )

        // ->groupBy('investor.id')
        // ->orderBy('investor.id','ASC');

        // $dt_perhitungan = $data_perhitungan->get();
        // $ttl_laba = $data_perhitungan->sum('tot_laba');

        // $dt_perhitungan = PersenInvestor::select('persen_investor.persen','investor.nm_investor','cabang.nama')->selectRaw("dt_jurnal.ttl_laba")
        // ->leftJoin(
        //     DB::raw("(SELECT id, SUM(laba_rugi) as ttl_baba FROM view_jurnal where tgl >= '$request->tgl1' AND tgl <= '$request->tgl1' GROUP BY id) dt_jurnal"),
        //     'persen_investor.cabang_id','=','dt_jurnal.id'
        // )
        // ->leftJoin('investor','persen_investor.investor_id','=','investor.id')
        // ->leftJoin('cabang','persen_investor.cabang_id','=','cabang.id')
        // ->where('persen_investor.investor_id','!=',10)
        // ->orderBy('persen_investor.investor_zid','ASC')
        // ->get();

        $data_penjualan_investor = PenjualanInvestor::select('penjualan_investor.persen', 'penjualan_investor.tgl', 'penjualan_investor.cabang_id', 'penjualan_investor.investor_id')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('investor_id', Auth::id())->groupBy('cabang_id')->groupBy('tgl')->get();

        $dt_cabang_investor = PenjualanInvestor::select('cabang_id')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('investor_id', Auth::id())->groupBy('cabang_id')->get();

        $dt_cabang = [];
        foreach ($dt_cabang_investor as $c) {

            $dt_cabang[] = $c->cabang_id;
        }

        $akses_cabang = join(",", $dt_cabang);

        if ($dt_cabang_investor) {

            $biaya_oprational = AkunPengeluaran::select('akun_pengeluaran.id', 'nm_akun', 'jenis_akun_id')->selectRaw('dt_jurnal.ttl_debit')->leftJoin(
                DB::raw("(SELECT akun_id, SUM(debit) as ttl_debit FROM jurnal WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2'  AND void = 0 AND cabang_id IN (" . $akses_cabang . ") GROUP BY akun_id) dt_jurnal"),
                'akun_pengeluaran.id',
                '=',
                'dt_jurnal.akun_id'
            )->whereIn('jenis_akun_id', [5, 3])->get();

            $cabang = Jurnal::select('cabang_id', 'tgl')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('void', 0)->where('cabang_id', '!=', 0)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_penjualan = PenjualanKasir::select('cabang_id', 'tgl')->selectRaw("SUM(qty * harga_normal) as total_jual")->where('void', '!=', 2)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_invoice = InvoiceKasir::select('cabang_id', 'tgl')->selectRaw("SUM(diskon) as jml_diskon")->where('void', '!=', 2)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_persen_gaji_office = PenjualanGajiOffice::select('cabang_id', 'tgl')->selectRaw('SUM( (persen_gaji * jumlah) / 100) as persen_office ')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_persen_gaji = PenjualanGaji::select('cabang_id', 'tgl', 'persen_gaji')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_gapok_office = GapokOffice::select('cabang_id', 'tgl')->selectRaw('SUM(gapok) as ttl_gapok')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_biaya_oprasional = Jurnal::select('cabang_id', 'tgl')->selectRaw('SUM(debit) as ttl_debit')->leftJoin('akun_pengeluaran', 'jurnal.akun_id', '=', 'akun_pengeluaran.id')->where('void', 0)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('jenis_akun_id', [5, 3])->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_barang_kebutuhan = Jurnal::select('cabang_id', 'tgl')->selectRaw("SUM(kredit) as ttl_kebutuhan")->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('void', 0)->where('akun_id', 14)->whereIn('cabang_id', $dt_cabang)->groupBy('cabang_id')->groupBy('tgl')->get();
            $dat_stok = Stok::select('cabang_id', 'tgl')->selectRaw("SUM(IF(jenis = 'Keluar',harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', harga,0)) as harga_refund")->where('stok.tgl', '>=', $request->tgl1)->where('stok.tgl', '<=', $request->tgl2)->whereIn('jenis', ['Keluar', 'Refund'])->whereIn('cabang_id', $dt_cabang)->groupBy('stok.cabang_id')->groupBy('stok.tgl')->get();
            // $dat_investor = PenjualanInvestor::select('cabang_id', 'tgl')->selectRaw('SUM(persen) as ttl_persen')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->groupBy('cabang_id')->groupBy('tgl')->get();

            $penjualan = 0;
            $persen_office = 0;
            $persen_crew = 0;
            $gapok_crew = 0;
            $gapok_office = 0;
            $biaya = 0;
            $barang_kebutuhan = 0;
            $stok = 0;
            $tot_laba = 0;
            $investor = 0;

            $ttl_persen_investor = 0;
            // $data_cabangs = [];
            foreach ($cabang as $c) {
                $laba = 0;

                $dt_penjualan = $dat_penjualan->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $dt_invoice = $dat_invoice->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $penjualan += (($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0));
                $laba += (($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0));

                $dt_persen_gaji_office = $dat_persen_gaji_office->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_persen_gaji_office ? $dt_persen_gaji_office->persen_office : 0;
                $persen_office += $dt_persen_gaji_office ? $dt_persen_gaji_office->persen_office : 0;

                $dt_persen_gaji = $dat_persen_gaji->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_persen_gaji && $dt_penjualan ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) > 0 && $dt_persen_gaji->persen_gaji > 0 ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) * $dt_persen_gaji->persen_gaji) / 100 : 0) : 0;
                $persen_crew += $dt_persen_gaji && $dt_penjualan ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) > 0 && $dt_persen_gaji->persen_gaji > 0 ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) * $dt_persen_gaji->persen_gaji) / 100 : 0) : 0;

                $dt_gapok_office = $dat_gapok_office->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_gapok_office ? $dt_gapok_office->ttl_gapok : 0;
                $gapok_office += $dt_gapok_office ? $dt_gapok_office->ttl_gapok : 0;

                $dt_biaya_oprasional = $dat_biaya_oprasional->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_biaya_oprasional ? $dt_biaya_oprasional->ttl_debit : 0;
                $biaya += $dt_biaya_oprasional ? $dt_biaya_oprasional->ttl_debit : 0;

                $dt_barang_kebutuhan = $dat_barang_kebutuhan->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_barang_kebutuhan ? $dt_barang_kebutuhan->ttl_kebutuhan : 0;
                $barang_kebutuhan += $dt_barang_kebutuhan ? $dt_barang_kebutuhan->ttl_kebutuhan : 0;

                $dt_stok = $dat_stok->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $laba -= $dt_stok ? ($dt_stok->harga_keluar - $dt_stok->harga_refund) : 0;
                $stok += $dt_stok ? ($dt_stok->harga_keluar - $dt_stok->harga_refund) : 0;

                $dt_investor = $data_penjualan_investor->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
                $investor += ($dt_investor && $laba ? $laba * $dt_investor->persen / 100 : 0);


                $tot_laba += $laba;

                // $data_cabangs[] = [
                //     'tgl' => $c->tgl,
                //     'cabang_id' => $c->cabang_id,
                //     'laba' => $laba,
                // ];
            }



            // $penjualan_investor = [];

            // foreach ($data_penjualan_investor as $i) {

            //     foreach ($data_cabangs as $cb) {
            //         if ($cb['tgl'] == $i->tgl && $cb['cabang_id'] == $i->cabang_id) {
            //             $penjualan_investor[] = [
            //                 'investor_id' => $i->investor_id,
            //                 'cabang_id' => $i->cabang_id,
            //                 'deviden' => $i->persen && $cb['laba'] ? $cb['laba'] * $i->persen / 100 : 0,
            //             ];
            //         }
            //     }
            // }

            // $data_investor = Investor::where('hapus', 0)->get();

            // $laba_investor = [];
            // foreach ($data_investor as $d) {
            //     $lb = 0;
            //     foreach ($penjualan_investor as $pi) {
            //         if ($pi['investor_id'] == $d->id) {
            //             $lb += $pi['deviden'];
            //         }
            //     }
            //     $laba_investor[] = [
            //         'id' => $d->id,
            //         'nm_investor' => $d->nm_investor,
            //         'deviden' => $lb,
            //     ];
            // }

            // dd($laba_investor);

            $data = [
                'stok' => $stok,
                // 'varian' => $varian,
                'biaya_oprational' => $biaya_oprational,
                'tgl1' => $request->tgl1,
                'tgl2' => $request->tgl2,
                'penjualan' => $penjualan,
                'barang_kebutuhan' => $barang_kebutuhan,
                'rusak' => 0,
                'penjualan_cabang' => 0,
                'gapok_office' => $gapok_office,
                'gapok_crew' => $gapok_crew,
                'persen_office' => $persen_office,
                'persen_crew' => $persen_crew,
                'ttl_persen_investor' => $tot_laba,
                'biaya' => $biaya,
                'investor' => $investor,
                'tot_laba' => $tot_laba,
            ];
            return view('component.dt_jurnal', $data)->render();
        } else {
            return 'Anda tidak memiliki data investor';
        }
    }


    public function dtPerOutlet(Request $request)
    {
        $data_penjualan_investor = PenjualanInvestor::select('penjualan_investor.persen', 'penjualan_investor.tgl', 'penjualan_investor.cabang_id', 'penjualan_investor.investor_id')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('investor_id', Auth::id())->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();

        $biaya_oprational = AkunPengeluaran::select('akun_pengeluaran.id', 'nm_akun', 'jenis_akun_id')->selectRaw('dt_jurnal.ttl_debit')->leftJoin(
            DB::raw("(SELECT akun_id, SUM(debit) as ttl_debit FROM jurnal WHERE tgl >= '$request->tgl1' AND tgl <= '$request->tgl2'  AND void = 0 AND cabang_id = '$request->cabang_id' GROUP BY akun_id) dt_jurnal"),
            'akun_pengeluaran.id',
            '=',
            'dt_jurnal.akun_id'
        )->whereIn('jenis_akun_id', [5, 3])->get();

        $cabang = Jurnal::select('cabang_id', 'tgl')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('void', 0)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_penjualan = PenjualanKasir::select('cabang_id', 'tgl')->selectRaw("SUM(qty * harga_normal) as total_jual")->where('void', '!=', 2)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_invoice = InvoiceKasir::select('cabang_id', 'tgl')->selectRaw("SUM(diskon) as jml_diskon")->where('void', '!=', 2)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_persen_gaji_office = PenjualanGajiOffice::select('cabang_id', 'tgl')->selectRaw('SUM( (persen_gaji * jumlah) / 100) as persen_office ')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_persen_gaji = PenjualanGaji::select('cabang_id', 'tgl', 'persen_gaji')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_gapok_office = GapokOffice::select('cabang_id', 'tgl')->selectRaw('SUM(gapok) as ttl_gapok')->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_biaya_oprasional = Jurnal::select('cabang_id', 'tgl')->selectRaw('SUM(debit) as ttl_debit')->leftJoin('akun_pengeluaran', 'jurnal.akun_id', '=', 'akun_pengeluaran.id')->where('void', 0)->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->whereIn('jenis_akun_id', [5, 3])->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_barang_kebutuhan = Jurnal::select('cabang_id', 'tgl')->selectRaw("SUM(kredit) as ttl_kebutuhan")->where('tgl', '>=', $request->tgl1)->where('tgl', '<=', $request->tgl2)->where('void', 0)->where('akun_id', 14)->where('cabang_id', $request->cabang_id)->groupBy('cabang_id')->groupBy('tgl')->get();
        $dat_stok = Stok::select('cabang_id', 'tgl')->selectRaw("SUM(IF(jenis = 'Keluar',harga,0)) as harga_keluar, SUM(IF(jenis = 'Refund', harga,0)) as harga_refund")->where('stok.tgl', '>=', $request->tgl1)->where('stok.tgl', '<=', $request->tgl2)->whereIn('jenis', ['Keluar', 'Refund'])->where('cabang_id', $request->cabang_id)->groupBy('stok.cabang_id')->groupBy('stok.tgl')->get();

        $penjualan = 0;
        $persen_office = 0;
        $persen_crew = 0;
        $gapok_crew = 0;
        $gapok_office = 0;
        $biaya = 0;
        $barang_kebutuhan = 0;
        $stok = 0;
        $tot_laba = 0;
        $investor = 0;

        foreach ($cabang as $c) {
            $laba = 0;

            $dt_penjualan = $dat_penjualan->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $dt_invoice = $dat_invoice->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $penjualan += (($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0));
            $laba += (($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0));

            $dt_persen_gaji_office = $dat_persen_gaji_office->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_persen_gaji_office ? $dt_persen_gaji_office->persen_office : 0;
            $persen_office += $dt_persen_gaji_office ? $dt_persen_gaji_office->persen_office : 0;

            $dt_persen_gaji = $dat_persen_gaji->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_persen_gaji && $dt_penjualan ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) > 0 && $dt_persen_gaji->persen_gaji > 0 ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) * $dt_persen_gaji->persen_gaji) / 100 : 0) : 0;
            $persen_crew += $dt_persen_gaji && $dt_penjualan ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) > 0 && $dt_persen_gaji->persen_gaji > 0 ? ((($dt_penjualan ? $dt_penjualan->total_jual : 0) - ($dt_invoice ? $dt_invoice->jml_diskon : 0)) * $dt_persen_gaji->persen_gaji) / 100 : 0) : 0;

            $dt_gapok_office = $dat_gapok_office->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_gapok_office ? $dt_gapok_office->ttl_gapok : 0;
            $gapok_office += $dt_gapok_office ? $dt_gapok_office->ttl_gapok : 0;

            $dt_biaya_oprasional = $dat_biaya_oprasional->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_biaya_oprasional ? $dt_biaya_oprasional->ttl_debit : 0;
            $biaya += $dt_biaya_oprasional ? $dt_biaya_oprasional->ttl_debit : 0;

            $dt_barang_kebutuhan = $dat_barang_kebutuhan->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_barang_kebutuhan ? $dt_barang_kebutuhan->ttl_kebutuhan : 0;
            $barang_kebutuhan += $dt_barang_kebutuhan ? $dt_barang_kebutuhan->ttl_kebutuhan : 0;

            $dt_stok = $dat_stok->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $laba -= $dt_stok ? ($dt_stok->harga_keluar - $dt_stok->harga_refund) : 0;
            $stok += $dt_stok ? ($dt_stok->harga_keluar - $dt_stok->harga_refund) : 0;

            $dt_investor = $data_penjualan_investor->where('cabang_id', $c->cabang_id)->where('tgl', $c->tgl)->first();
            $investor += ($dt_investor && $laba ? $laba * $dt_investor->persen / 100 : 0);


            $tot_laba += $laba;

            // $data_cabangs[] = [
            //     'tgl' => $c->tgl,
            //     'cabang_id' => $c->cabang_id,
            //     'laba' => $laba,
            // ];
        }

        $data = [
            'stok' => $stok,
            // 'varian' => $varian,
            'biaya_oprational' => $biaya_oprational,
            'tgl1' => $request->tgl1,
            'tgl2' => $request->tgl2,
            'penjualan' => $penjualan,
            'barang_kebutuhan' => $barang_kebutuhan,
            'rusak' => 0,
            'penjualan_cabang' => 0,
            'gapok_office' => $gapok_office,
            'gapok_crew' => $gapok_crew,
            'persen_office' => $persen_office,
            'persen_crew' => $persen_crew,
            'ttl_persen_investor' => $tot_laba,
            'biaya' => $biaya,
            'investor' => $investor,
            'tot_laba' => $tot_laba,
        ];
        return view('component.dt_jurnal_peroutlet', $data)->render();
    }
}
