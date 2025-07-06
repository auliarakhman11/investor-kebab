<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\HargaPengeluaran;
use App\Models\Kota;
use App\Models\UserKasir;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Outlet',
            'outlet' => Cabang::select('cabang.id as id','foto','cabang.nama','cabang.kota_id','alamat','map','kota.nm_kota','event','no_tlpn','email_gojek','email_grab','email_shopee','time_zone','off')->leftJoin('kota','cabang.kota_id','=','kota.id')->orderBy('possition','ASC')->with(['hargaPengeluaran'])->get(),
            'kota' => Kota::all(),
            // 'akun' => AkunPengeluaran::all(),
            'akun' => AkunPengeluaran::where('jenis_akun_id',5)->get(),
        ];
        return view('page.outlet',$data);
    }

    public function sortOutlet(Request $request)
    {
        foreach($request->positions as $position) {

            Cabang::where('id',$position[0])->update([
                'possition' => $position[1]
            ]);
         }

         return true;
    }

    public function addOutlet(Request $request)
    {
        $request->validate([
            'foto' => 'image|mimes:jpg,png,jpeg'
        ]);
        // if($request->file('foto')){
        //     $foto = $request->file('foto')->store('img-outlet');
        // }else{
        //     $foto='';
        // }
        if($request->file('foto')){
            $request->file('foto')->move('img-outlet/',$request->file('foto')->getClientOriginalName());
        $foto = 'img-outlet/'.$request->file('foto')->getClientOriginalName();
        }else{
            $foto='';
        }    
        
        $urutan = Cabang::orderBy('possition','DESC')->first();
        $data = [
            'nama' => $request->nama,
            'kota_id' => $request->kota_id,
            'alamat' => $request->alamat,
            'foto' => $foto,
            'map' => $request->map,
            'event' => $request->event,
            'no_tlpn' => $request->no_tlpn,
            'email_gojek' => $request->email_gojek,
            'email_grab' => $request->email_grab,
            'email_shopee' => $request->email_shopee,
            'time_zone' => $request->time_zone,
            // 'gapok' => $request->gapok,
            'off' => $request->off,
            'urutan' => $urutan->possition + 1,
        ];
        $cabang = Cabang::create($data);

        $akun_id = $request->akun_id;
        $harga = $request->harga;

        for($count = 0; $count<count($akun_id); $count++){
                $harga_insert = [
                    'cabang_id' => $cabang->id,
                    'akun_id' => $akun_id[$count],
                    'harga' => $harga[$count]                    
                ]; 
                HargaPengeluaran::create($harga_insert);
        }

        
        return redirect(route('outlet'))->with('success','Data berhasil dibuat');
    }

    public function editOutlet(Request $request)
    {
        // dd($request);
        $request->validate([
            'foto' => 'image|mimes:jpg,png,jpeg'
        ]);
        if($request->file('foto')){
            $request->file('foto')->move('img-outlet/',$request->file('foto')->getClientOriginalName());
            $foto = 'img-outlet/'.$request->file('foto')->getClientOriginalName();
            $data = [
                'nama' => $request->nama,
                'kota_id' => $request->kota_id,
                'alamat' => $request->alamat,
                'foto' => $foto,
                'map' => $request->map,
                'no_tlpn' => $request->no_tlpn,
                'email_gojek' => $request->email_gojek,
                'email_grab' => $request->email_grab,
                'email_shopee' => $request->email_shopee,
                'event' => $request->event,
                // 'gapok' => $request->gapok,
                'off' => $request->off,
                'time_zone' => $request->time_zone,
            ];
        }else{
            $data = [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'map' => $request->map,
                'no_tlpn' => $request->no_tlpn,
                'email_gojek' => $request->email_gojek,
                'email_grab' => $request->email_grab,
                'email_shopee' => $request->email_shopee,
                'kota_id' => $request->kota_id,
                'event' => $request->event,
                // 'gapok' => $request->gapok,
                'off' => $request->off,
                'time_zone' => $request->time_zone,
            ];
        }

        Cabang::where('id',$request->id)->update($data);

        UserKasir::where('cabang_id',$request->id)->update(['time_zone' => $request->time_zone]);

        return redirect(route('outlet'))->with('success','Data berhasil diubah');
    }

    public function editHargaPengeluaran(Request $request)
    {
        if($request->akun_id){
            $akun_id = $request->akun_id;
            $harga = $request->harga;

            for($count = 0; $count<count($akun_id); $count++){
                $harga_update = [
                    'harga' => $harga[$count]                    
                ];
                $cek = HargaPengeluaran::where('akun_id',$akun_id[$count])->where('cabang_id',$request->cabang_id)->first();
                if($cek){
                    HargaPengeluaran::where('akun_id',$akun_id[$count])->where('cabang_id',$request->cabang_id)->update($harga_update);
                }else{
                    $harga_insert = [
                        'cabang_id' => $request->cabang_id,
                        'akun_id' => $akun_id[$count],
                        'harga' => $harga[$count]                    
                    ];
                    HargaPengeluaran::create($harga_insert);
                }
                
            }
        }

        return redirect(route('outlet'))->with('success','Data berhasil diubah');
    }

    public function grandManager()
    {
        $data = [
            'title' => 'Grand Manager',
            'kota' => Kota::all(),
            // 'akun' => AkunPengeluaran::where('jenis_akun_id',5)->get(),
        ];
        return view('page.kota',$data);
    }

    public function addKota(Request $request)
    {
        $data = [
            'nm_kota' => $request->nm_kota
        ];
        $kota = Kota::create($data);

        // $akun_id = $request->akun_id;
        // $harga = $request->harga;

        // for($count = 0; $count<count($akun_id); $count++){
        //         $harga_insert = [
        //             'kota_id' => $kota->id,
        //             'akun_id' => $akun_id[$count],
        //             'harga' => $harga[$count]                    
        //         ]; 
        //         HargaPengeluaran::create($harga_insert);
        // }

        
        return redirect(route('grandManager'))->with('success','Data berhasil dibuat');
    }

}
