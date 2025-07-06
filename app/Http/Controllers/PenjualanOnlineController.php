<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Invoice;
use App\Models\Penjualan;
use App\Models\UserKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanOnlineController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->query('tgl1')){
            $tgl1 = $request->query('tgl1');
            $tgl2 = $request->query('tgl2');
        }else{
            $tgl1 = date('Y-m-d', strtotime("-7 day", strtotime(date("Y-m-d"))));
            $tgl2 = date('Y-m-d');
        }
        $data = [
            'title' => 'Penjuala Online',
            'invoice' => Invoice::where('invoice.tgl','>=',$tgl1)->where('invoice.tgl','<=',$tgl2)->orderBy('invoice.status','ASC')->orderBy('invoice.cabang_id','DESC')->with(['penjualan','costumer','penjualan.getMenu','cabang','penjualan.penjualanVarian'])->get(),
            'outlet' => Cabang::all(),
        ];
        return view('page.penjol',$data);
        // $inv = Invoice::with(['penjualan','costumer','penjualan.getMenu'])->first();
        // dd($inv->penjualan);
    }

    public function aksiPenjualan(Request $request)
    {
        if($request->tombol == 'selesai'){
            $inv = $request->no_invoice;
            $data_inv = [
                'admin' => Auth::user()->id,
                'cabang_id' => $request->cabang_id
            ];
            Invoice::where('no_invoice',$inv)->update($data_inv);

            $data_penjualan = [
                'admin' => Auth::user()->id,
            ];
            Penjualan::where('no_invoice',$inv)->update($data_penjualan);

            $url = 'https://fcm.googleapis.com/fcm/send';
                $FcmToken = UserKasir::whereNotNull('device_key')->where('cabang_id',$request->cabang_id)->pluck('device_key')->all();
                
                $serverKey = 'AAAAKeEx290:APA91bFLTYQgLE3wxi9vzshm_Z5upOllIOWmTFfczdHAU_pGjqmzjmeNEU4f3AaCOCKbHR8z3OGJpxVCTpyQc1pJpO_0Ph47KkmcC69hqTTim4rItY6-xvBnF59-B68sqiAtN_aHzphF';
        
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => 'Pesanan Baru',
                        "body" => 'Ada pesanann baru!!!',  
                    ]
                ];
                $encodedData = json_encode($data);
            
                $headers = [
                    'Authorization:key=' . $serverKey,
                    'Content-Type: application/json',
                ];
            
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                // Execute post
                $result = curl_exec($ch);
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }        
                // Close connection
                curl_close($ch);

            return redirect(route('penjol'))->with('success','Pesanan diproses');
        }
    }

    public function selesai(Request $request)
    {
        $id_inv = $request->id_inv;

        $data_inv = [
            'admin' => Auth::user()->id,
            'status' => 'Selesai'
        ];
        Invoice::where('id',$id_inv)->update($data_inv);

        return redirect(route('penjol'))->with('success','Pesanan berhasil diselesaikan');
    }

    public function voidPenjol(Request $request)
    {
        $id_inv = $request->id_inv;

        $data_inv = [
            'admin' => Auth::user()->id,
            'status' => 'Tertolak'
        ];
        Invoice::where('id',$id_inv)->update($data_inv);

        return redirect(route('penjol'))->with('success','Pesanan berhasil ditolak');
    }
}
