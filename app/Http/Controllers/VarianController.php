<?php

namespace App\Http\Controllers;

use App\Models\HargaVarian;
use App\Models\HargaVarianMitra;
use App\Models\KategoriVarian;
use App\Models\Kota;
use App\Models\Mitra;
use App\Models\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Varian',
            // 'kategori_varian' => KategoriVarian::orderBy('id','ASC')->with(['getVarian'])->get(),
            'varian' => Varian::where('kategori_varian_id',1)->with('hargaVarian','hargaVarianMitra')->get(),
            'kota' => Kota::all(),
            'mitra' => Mitra::all(),
        ];
        return view('page.varian',$data);
    }

    public function addVarian(Request $request)
    {
        $data = [
            'nm_varian' => $request->nm_varian,
            'kategori_varian_id' => 1,
            'harga' => 0,
            'harga_beli' => $request->harga_beli, 
        ];
        $varian = Varian::create($data);

        if($request->kota_id){
            $kota_id = $request->kota_id;
            $harga = $request->harga;
            $stok_baku = $request->stok_baku;

            for($count = 0; $count<count($kota_id); $count++){
                $harga_varian = [
                    'varian_id' => $varian->id,
                    'kota_id' => $kota_id[$count],
                    'harga' => $harga[$count],
                    'stok_baku' => $stok_baku[$count],                    
                ];
                HargaVarian::create($harga_varian);
            }
        }

        if($request->mitra_id){
            $mitra_id = $request->mitra_id;
            $harga_mitra = $request->harga_mitra;

            for($count = 0; $count<count($mitra_id); $count++){
                $harga_varian_mitra = [
                    'varian_id' => $varian->id,
                    'mitra_id' => $mitra_id[$count],
                    'harga' => $harga_mitra[$count],                   
                ];
                HargaVarianMitra::create($harga_varian_mitra);
            }
        }
            

        return redirect(route('varian'))->with('success','Data berhasil dibuat');
    }

    public function editVarian(Request $request)
    {
        $id = $request->id;
        $nm_varian = $request->nm_varian;
        $harga = $request->harga;
        $stok_baku = $request->stok_baku;

            $data = [
                'nm_varian' => $nm_varian,
                'harga_beli' => $request->harga_beli,
            ];
            Varian::where('id',$id)->update($data);
        
            if($request->kota_id){
                $kota_id = $request->kota_id;
                $harga = $request->harga;
    
                for($count = 0; $count<count($kota_id); $count++){
                    $harga_varian = [
                        'harga' => $harga[$count],
                        'stok_baku' => $stok_baku[$count],              
                    ];
                    $cek = HargaVarian::where('kota_id',$kota_id[$count])->where('varian_id',$request->id)->first();
                    if($cek){
                        HargaVarian::where('kota_id',$kota_id[$count])->where('varian_id',$request->id)->update($harga_varian);
                    }else{
                        $harga_varian_insert = [
                            'varian_id' => $request->id,
                            'kota_id' => $kota_id[$count],
                            'harga' => $harga[$count],
                            'stok_baku' => $stok_baku[$count],                 
                        ];
                        HargaVarian::create($harga_varian_insert);
                    }
                    
                }
            }


            if($request->mitra_id){
                $mitra_id = $request->mitra_id;
                $harga_mitra = $request->harga_mitra;
    
                for($count = 0; $count<count($mitra_id); $count++){
                    $harga_varian_mitra = [
                        'harga' => $harga_mitra[$count],              
                    ];
                    $cek = HargaVarianMitra::where('mitra_id',$mitra_id[$count])->where('varian_id',$request->id)->first();
                    if($cek){
                        HargaVarianMitra::where('mitra_id',$mitra_id[$count])->where('varian_id',$request->id)->update($harga_varian_mitra);
                    }else{
                        $harga_varian_mitra_insert = [
                            'varian_id' => $request->id,
                            'mitra_id' => $mitra_id[$count],
                            'harga' => $harga_mitra[$count],             
                        ];
                        HargaVarianMitra::create($harga_varian_mitra_insert);
                    }
                    
                }
            }

        return redirect(route('varian'))->with('success','Data berhasil diedit');
    }
}
