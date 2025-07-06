<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Delivery;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Harga;
use App\Models\Kota;
use App\Models\ProdukKota;
use App\Models\Resep;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // $produk = Produk::orderBy('possition','ASC')->with(['kategori','getHarga','getHarga.delivery','produkKota'])->take(10)->get();
        // dd($produk[0]->produkKota[0]->kota_id);
        // dd(Produk::orderBy('possition','ASC')->with(['kategori','getHarga','getHarga.delivery','produkKota'])->take(10)->get());
        $data = [
            'title' => 'Products',
            'kategori' => Kategori::all(),
            'delivery' => Delivery::all(),
            'produk' => Produk::orderBy('possition','ASC')->with(['kategori','getHarga','getHarga.delivery','produkKota'])->where('hapus',0)->get(),
            'bahan' => Bahan::all(),
            'kota' => Kota::all()
        ];
        // $produk = Produk::with(['kategori','getHarga.delivery'])->get();
        // dd($produk[0]);
        return view('page.products',$data);
        // $produk = Produk::with(['kategori','getHarga'])->first();
        
    }

    public function sortProduk(Request $request)
    {
        foreach($request->positions as $position) {

            Produk::where('id',$position[0])->update([
                'possition' => $position[1]
            ]);
         }

         return true;
    }

    public function addProduct(Request $request)
    {
        if($request->kota_id){
            $request->validate([
                'foto' => 'image|mimes:jpg,png,jpeg'
            ]);
            // if($request->file('foto')){
            //     $foto = $request->file('foto')->store('img-produk');
            // }else{
            //     $foto='';
            // }
    
            if($request->hasFile('foto')){
                $request->file('foto')->move('img-produk/',$request->file('foto')->getClientOriginalName());
                $foto = 'img-produk/'.$request->file('foto')->getClientOriginalName();
            }else{
                $foto = '';
            }
    
            $last_produk = Produk::orderBy('possition','DESC')->first();
            
            $data = [
                'kategori_id' => $request->kategori_id,
                'nm_produk' => $request->nm_produk,
                'status' => $request->status,
                'diskon ' => 0,
                'foto' => $foto,
                'possition' => $last_produk->possition + 1,
                'hapus' => 0,
            ];
            $produk = Produk::create($data);
            if($request->delivery_id){
                $delivery_id = $request->delivery_id;
                $harga = $request->harga;
    
                for($count = 0; $count<count($delivery_id); $count++){
                    $delivery = [
                        'produk_id' => $produk->id,
                        'delivery_id' => $delivery_id[$count],
                        'harga' => $harga[$count]                    
                    ];
                    Harga::create($delivery);
                }
            }

            $kota_id = $request->kota_id;
            ProdukKota::where('produk_id',$produk->id)->delete();
            for($count = 0; $count<count($kota_id); $count++){


                ProdukKota::create([
                    'produk_id' => $produk->id,
                    'kota_id' => $kota_id[$count]                 
                ]);
                                
            }
            
            return redirect(route('products'))->with('success','Data berhasil dibuat');
        }else{
            return redirect(route('products'))->with('error','Masukan data kota terlebih dahulu');
        }
        
    }

    public function editProduk(Request $request)
    {
        if($request->kota_id){

            $request->validate([
                'foto' => 'image|mimes:jpg,png,jpeg'
            ]);
            if($request->file('foto')){
                $request->file('foto')->move('img-produk/',$request->file('foto')->getClientOriginalName());
                $foto = 'img-produk/'.$request->file('foto')->getClientOriginalName();
                $data = [
                    'kategori_id' => $request->kategori_id,
                    'nm_produk' => $request->nm_produk,
                    'status' => $request->status,
                    'foto' => $foto
                ];
            }else{
                $data = [
                    'kategori_id' => $request->kategori_id,
                    'nm_produk' => $request->nm_produk,
                    'status' => $request->status
                ];
            }
            
            
            Produk::where('id',$request->id)->update($data);
            if($request->delivery_id){
                $delivery_id = $request->delivery_id;
                $harga = $request->harga;
    
                for($count = 0; $count<count($delivery_id); $count++){
                    $delivery = [
                        'harga' => $harga[$count]                    
                    ];
                    $cek = Harga::where('delivery_id',$delivery_id[$count])->where('produk_id',$request->id)->first();
                    if($cek){
                        Harga::where('delivery_id',$delivery_id[$count])->where('produk_id',$request->id)->update($delivery);
                    }else{
                        $delivery_insert = [
                            'produk_id' => $request->id,
                            'delivery_id' => $delivery_id[$count],
                            'harga' => $harga[$count]                    
                        ];
                        Harga::create($delivery_insert);
                    }
                    
                }
            }

            $kota_id = $request->kota_id;
            ProdukKota::where('produk_id',$request->id)->delete();
            for($count = 0; $count<count($kota_id); $count++){


                ProdukKota::create([
                    'produk_id' => $request->id,
                    'kota_id' => $kota_id[$count]                 
                ]);
                                
            }
            
            return redirect(route('products'))->with('success','Data berhasil diupdate');

        }else{
            return redirect(route('products'))->with('error','Masukan data kota terlebih dahulu');
        }
        
    }

    public function getResep(Request $request)
    {
        $id = $request->query('id');
        $data = [
            'bahan' => Bahan::all(),
            'count_kota' => Kota::count(),
            'kota' => Kota::all(),
            'resep' => Resep::where('produk_id',$id)->with(['bahan','hargaBahan'])->get(),
            'harga' => Resep::select('kota.nm_kota')->selectRaw("SUM(harga_bahan.harga * resep.takaran) as ttl_harga")->leftJoin('harga_bahan','resep.bahan_id','=','harga_bahan.bahan_id')->leftJoin('kota','harga_bahan.kota_id','=','kota.id')->where('resep.produk_id',$id)->groupBy('harga_bahan.kota_id')->get(),
        ];
        return view('component.resep',$data)->render();
    }

    public function addResep(Request $request)
    {
        $produk_id = $request->produk_id;
        $bahan_id = $request->bahan_id;
        $takaran = $request->takaran;

        for($count = 0; $count<count($bahan_id); $count++){
            $cek = Resep::where('produk_id',$produk_id)->where('bahan_id',$bahan_id[$count])->first();
            if($cek){continue;}
            $data  = [
                'produk_id' => $produk_id,
                'bahan_id' => $bahan_id[$count],
                'takaran' => $takaran[$count]
            ];
            Resep::create($data);
        }
        
        return true;
        
    }

    public function dropResep(Request $request)
    {
        Resep::find($request->id)->delete();

        return true;
    }

    public function deleteProduk($id)
    {
        Produk::where('id',$id)->update([
            'hapus' => 1,
            'status' => 'OFF'
        ]);

        return redirect(route('products'))->with('success','Data berhasil dihapus');
    }

}
