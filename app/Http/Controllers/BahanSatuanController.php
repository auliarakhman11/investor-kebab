<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\HargaBahan;
use App\Models\HargaBahanMitra;
use App\Models\JenisBahan;
use App\Models\Kota;
use App\Models\Mitra;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BahanSatuanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Varian',
            'bahan' => Bahan::where('aktif','Y')->orderBy('possition','ASC')->with(['satuan','jenisBahan','hargaBahan.kota', 'hargaBahanMitra'])->get(),
            'satuan' => Satuan::all(),
            'jenis_bahan' => JenisBahan::all(),
            'kota' => Kota::all(),
            'mitra' => Mitra::all(),
        ];
        return view('page.bahan_satuan',$data);
    }

    public function sortBahan(Request $request)
    {
        foreach($request->positions as $position) {

            Bahan::where('id',$position[0])->update([
                'possition' => $position[1]
            ]);
         }

         return true;
    }

    public function addSatuan(Request $request)
    {
        $cek = Satuan::where('satuan',$request->satuan)->first();
        if($cek){
            return redirect(route('bahanSatuan'))->with('error','Satuan sudah ada');
        }else{
            $data = [
                'satuan' => $request->satuan,
            ];
            Satuan::create($data);
            return redirect(route('bahanSatuan'))->with('success','Data berhasil dibuat');
        }
        
    }

    public function addBahan(Request $request)
    {

        $cek = Bahan::where('bahan',$request->bahan)->where('aktif','Y')->first();

        if($cek){
            return redirect(route('bahanSatuan'))->with('error','Bahan sudah ada');
        }else{
            $urutan = Bahan::where('aktif','Y')->orderBy('possition','DESC')->first();
            $data = [
                'satuan_id' => $request->satuan_id,
                'bahan' => $request->bahan,
                'jenis_bahan_id' => $request->jenis_bahan_id,
                'harga_beli' => $request->harga_beli,
                'possition' => $urutan->possition + 1,
            ];
            $bahan = Bahan::create($data);

            if($request->kota_id){
                $kota_id = $request->kota_id;
                $harga = $request->harga;
                $stok_baku = $request->stok_baku;
    
                for($count = 0; $count<count($kota_id); $count++){
                    $harga_bahan = [
                        'bahan_id' => $bahan->id,
                        'kota_id' => $kota_id[$count],
                        'harga' => $harga[$count],
                        'stok_baku' => $stok_baku[$count],              
                    ];
                    HargaBahan::create($harga_bahan);
                }
            }

            if($request->mitra_id){
                $mitra_id = $request->mitra_id;
                $harga_mitra = $request->harga_mitra;
    
                for($count = 0; $count<count($mitra_id); $count++){
                    $harga_bahan_mitra = [
                        'bahan_id' => $bahan->id,
                        'mitra_id' => $mitra_id[$count],
                        'harga' => $harga_mitra[$count],           
                    ];
                    HargaBahanMitra::create($harga_bahan_mitra);
                }
            }

            return redirect(route('bahanSatuan'))->with('success','Data berhasil dibuat');
        }

        
    }

    public function editBahan(Request $request)
    {
        $data = [
            'satuan_id' => $request->satuan_id,
            'bahan' => $request->bahan,
            'harga_beli' => $request->harga_beli,
            'jenis_bahan_id' => $request->jenis_bahan_id,
        ];
        Bahan::where('id',$request->id)->update($data);

        if($request->kota_id){
            $kota_id = $request->kota_id;
            $harga = $request->harga;
            $stok_baku = $request->stok_baku;

            for($count = 0; $count<count($kota_id); $count++){
                $harga_bahan = [
                    'harga' => $harga[$count],
                    'stok_baku' => $stok_baku[$count],                    
                ];
                $cek = HargaBahan::where('kota_id',$kota_id[$count])->where('bahan_id',$request->id)->first();
                if($cek){
                    HargaBahan::where('kota_id',$kota_id[$count])->where('bahan_id',$request->id)->update($harga_bahan);
                }else{
                    $harga_bahan_insert = [
                        'bahan_id' => $request->id,
                        'kota_id' => $kota_id[$count],
                        'harga' => $harga[$count],
                        'stok_baku' => $stok_baku[$count],                    
                    ];
                    HargaBahan::create($harga_bahan_insert);
                }
                
            }
        }

        if($request->mitra_id){
            $mitra_id = $request->mitra_id;
            $harga_mitra = $request->harga_mitra;
            $stok_baku = $request->stok_baku;

            for($count = 0; $count<count($mitra_id); $count++){
                $harga_bahan_mitra = [
                    'harga' => $harga_mitra[$count],                    
                ];
                $cek = HargaBahanMitra::where('mitra_id',$mitra_id[$count])->where('bahan_id',$request->id)->first();
                if($cek){
                    HargaBahanMitra::where('mitra_id',$mitra_id[$count])->where('bahan_id',$request->id)->update($harga_bahan_mitra);
                }else{
                    $harga_bahan_mitra_insert = [
                        'bahan_id' => $request->id,
                        'mitra_id' => $mitra_id[$count],
                        'harga' => $harga_mitra[$count],                   
                    ];
                    HargaBahanMitra::create($harga_bahan_mitra_insert);
                }
                
            }
        }

        return redirect(route('bahanSatuan'))->with('success','Data berhasil diubah');
    }

    public function editSatuan(Request $request)
    {
        $data = [
            'satuan' => $request->satuan,
        ];
        Satuan::where('id',$request->id)->update($data);
        return redirect(route('bahanSatuan'))->with('success','Data berhasil diubah');
    }

    public function dropDataBahan(Request $request)
    {
        $data = [
            'aktif' => 'T'
        ];

        Bahan::where('id',$request->id)->update($data);
        return redirect(route('bahanSatuan'))->with('success','Data berhasil dihapus');
    }

}
