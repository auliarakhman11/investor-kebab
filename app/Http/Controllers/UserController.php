<?php

namespace App\Http\Controllers;

use App\Models\AksesKota;
use App\Models\Kota;
use App\Models\Posisi;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Users Management',
            'users' => User::where('aktif',1)->with(['posisi','aksesKota.kota'])->get(),
            'posisi' => Posisi::all(),
            'kota' => Kota::all(),
        ];

        // dd(User::with(['posisi','aksesKota.kota'])->get());

        return view('page.users',$data);
        // $produk = Produk::with(['kategori','getHarga'])->first();
        // dd($produk->getHarga[0]->harga);
    }

    public function addUser()
    {
       request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required']
        ]);

        if(request('kota_id')){
            $kota_id = request('kota_id');
            $user = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'role' => request('role'),
                'password' => bcrypt(request('password')),
                'aktif' => 1,
            ]);
            
            for($count = 0; $count<count($kota_id); $count++){
                AksesKota::create([
                    'user_id' => $user->id,
                    'kota_id' => $kota_id[$count],
                ]);
            }
            
            return redirect()->back()->with('success' , 'Data user berhasil dibuat');
        }else{
            return redirect()->back()->with('error_kota' , 'Data Kota Belum Diisi');
        }   
            

        
    }

    public function editUser(Request $request)
    {
        request()->validate([
            'role' => ['required']
        ]);
        $kota_id = $request->kota_id;
        if($kota_id){
        User::where('id',$request->id)->update([
            'role' => $request->role,
            'aktif' => $request->aktif
        ]);

        AksesKota::where('user_id',$request->id)->delete();

       
            for($count = 0; $count<count($kota_id); $count++){
                AksesKota::create([
                    'user_id' => $request->id,
                    'kota_id' => $kota_id[$count],
                ]);
            }

            return redirect()->back()->with('success' , 'Data user berhasil diedit');
        }else{
            return redirect()->back()->with('error_kota' , 'Data Kota Belum Diisi');
        }

        
    }

    public function block()
    {
        return view('page.block');
    }

    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
    
    public function deleteUser($id)
    {
        User::where('id',$id)->update([
            'aktif' => 0
        ]);
        return redirect()->back()->with('success' , 'Data berhasil dihapus');
    }
}
