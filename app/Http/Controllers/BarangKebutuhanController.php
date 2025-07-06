<?php

namespace App\Http\Controllers;

use App\Models\BarangKebutuhan;
use App\Models\HargaKebutuhan;
use App\Models\HargaKebutuhanMitra;
use App\Models\Kota;
use App\Models\Mitra;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangKebutuhanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Varian',
            'barang' => BarangKebutuhan::where('aktif',1)->with(['satuan','hargaKebutuhan','hargaKebutuhanMitra'])->get(),
            'satuan' => Satuan::all(),
            'kota' => Kota::all(),
            'mitra' => Mitra::all(),
        ];
        return view('page.barang_kebutuhan',$data);
    }

    public function addBarangKebutuhan(Request $request)
    {

        $cek = BarangKebutuhan::where('nm_barang',$request->nm_barang)->where('aktif',1)->first();

        if($cek){
            return redirect(route('barangKebutuhan'))->with('error','Barang sudah ada');
        }else{
            $data = [
                'satuan_id' => $request->satuan_id,
                'nm_barang' => $request->nm_barang,
                'aktif' => 1,
                'harga' => 0,
                'harga_beli' => $request->harga_beli,
            ];
            $barang_kebutuhan = BarangKebutuhan::create($data);

            if($request->kota_id){
                $kota_id = $request->kota_id;
                $harga = $request->harga;
                $stok_baku = $request->stok_baku;
    
                for($count = 0; $count<count($kota_id); $count++){
                    $harga_kebutuhan = [
                        'barang_kebutuhan_id' => $barang_kebutuhan->id,
                        'kota_id' => $kota_id[$count],
                        'harga' => $harga[$count],
                        'stok_baku' => $stok_baku[$count],             
                    ];
                    HargaKebutuhan::create($harga_kebutuhan);
                }
            }

            if($request->mitra_id){
                $mitra_id = $request->mitra_id;
                $harga_mitra = $request->harga_mitra;
    
                for($count = 0; $count<count($mitra_id); $count++){
                    $harga_kebutuhan_mitra = [
                        'barang_kebutuhan_id' => $barang_kebutuhan->id,
                        'mitra_id' => $mitra_id[$count],
                        'harga' => $harga_mitra[$count],    
                    ];
                    HargaKebutuhanMitra::create($harga_kebutuhan_mitra);
                }
            }

            return redirect(route('barangKebutuhan'))->with('success','Data berhasil dibuat');
        }

        
    }

    public function editBarangKebutuhan(Request $request)
    {
        $data = [
            'satuan_id' => $request->satuan_id,
            'nm_barang' => $request->nm_barang,
            'harga' => 0,
            'harga_beli' => $request->harga_beli,
        ];
        BarangKebutuhan::where('id',$request->id)->update($data);
        
        if($request->kota_id){
            $kota_id = $request->kota_id;
            $harga = $request->harga;
            $stok_baku = $request->stok_baku;

            for($count = 0; $count<count($kota_id); $count++){
                $harga_kebutuhan = [
                    'harga' => $harga[$count],
                    'stok_baku' => $stok_baku[$count],                   
                ];
                $cek = HargaKebutuhan::where('kota_id',$kota_id[$count])->where('barang_kebutuhan_id',$request->id)->first();
                if($cek){
                    HargaKebutuhan::where('kota_id',$kota_id[$count])->where('barang_kebutuhan_id',$request->id)->update($harga_kebutuhan);
                }else{
                    $harga_kebutuhan_insert = [
                        'barang_kebutuhan_id' => $request->id,
                        'kota_id' => $kota_id[$count],
                        'harga' => $harga[$count],
                        'stok_baku' => $stok_baku[$count],                 
                    ];
                    HargaKebutuhan::create($harga_kebutuhan_insert);
                }
                
            }
        }

        if($request->mitra_id){
            $mitra_id = $request->mitra_id;
            $harga_mitra = $request->harga_mitra;

            for($count = 0; $count<count($mitra_id); $count++){
                $harga_kebutuhan_mitra = [
                    'harga' => $harga_mitra[$count],                  
                ];
                $cek = HargaKebutuhanMitra::where('mitra_id',$mitra_id[$count])->where('barang_kebutuhan_id',$request->id)->first();
                if($cek){
                    HargaKebutuhanMitra::where('mitra_id',$mitra_id[$count])->where('barang_kebutuhan_id',$request->id)->update($harga_kebutuhan_mitra);
                }else{
                    $harga_kebutuhan_mitra_insert = [
                        'barang_kebutuhan_id' => $request->id,
                        'mitra_id' => $mitra_id[$count],
                        'harga' => $harga_mitra[$count],               
                    ];
                    HargaKebutuhanMitra::create($harga_kebutuhan_mitra_insert);
                }
                
            }
        }
        
        return redirect(route('barangKebutuhan'))->with('success','Data berhasil diubah');
    }

    public function dropBarangKebutuhan(Request $request)
    {
        $data = [
            'aktif' => 0
        ];

        BarangKebutuhan::where('id',$request->id)->update($data);
        return redirect(route('barangKebutuhan'))->with('success','Data berhasil dihapus');
    }

}
