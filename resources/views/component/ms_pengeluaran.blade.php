@php
    $p_infaq = explode(",", $_COOKIE['qty_infaq']) ;
    $p_semua = explode(",", $_COOKIE['qty_infaq']) ;

    $total_omset = explode(",", $_COOKIE['total_omset']) ;
@endphp

<div class="scroll_horizontal">
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999; font-size: 10px;">
      <thead>
        <tr>
          <th class="th-atas text-center" style="background-color: #757171">BAHAN BAKU</th>
          <th class="th-atas text-center" style="background-color: #A9D08E">HARGA</th>

        </tr>
        <tr>
          <th class="th-middle" colspan="2" style="color: white; background-color: white;">1</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($bahan as $b)
        
        <tr>
          <td style="background-color: white;">{{ $b->bahan }}</td>
          <td style="background-color: white; text-align: end;" >{{ number_format($b->harga,0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: white;">=</td>
          <td style="background-color: white;">=</td>
        </tr>

        @foreach ($barang_kebutuhan as $bk)
        
        <tr>
          <td style="background-color: white;">{{ $bk->nm_barang }}</td>
          <td style="background-color: white; text-align: end;" >{{ number_format($bk->harga,0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: white;">=</td>
          <td style="background-color: white;">=</td>
        </tr>

        @foreach ($akun_pengeluaran as $ak)
        <tr>
          <td style="background-color: white;">{{ $ak->nm_akun }}</td>
          <td style="background-color: white; text-align: end;" >{{ number_format($ak->harga,0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: white;">Per item</td>
          <td style="background-color: white; text-align: end;" >300</td>
        </tr>
        <tr>
          <td style="background-color: white;">Infaq</td>
          <td style="background-color: white; text-align: end;" >400</td>
        </tr>
        <tr>
          <td style="background-color: white;">Beban DLL</td>
          <td style="background-color: white; text-align: end;" >2,000</td>
        </tr>

        <tr>
          <td style="background-color: white;">=</td>
          <td style="background-color: white; text-align: end;" >=</td>
        </tr>

        <tr>
          <td style="background-color: #FF0000;" colspan="2">Total HHP</td>
        </tr>

        <tr>
          <td style="background-color: white;">=</td>
          <td style="background-color: white; text-align: end;" >=</td>
        </tr>

        <tr>
          <td style="background-color: #FF0000;" colspan="2">OMSET</td>
        </tr>

        <tr>
          <td style="background-color: #8EA9DB;" colspan="2">HHP</td>
        </tr>

        <tr>
          <td style="background-color: #A9D08E;" colspan="2">KEUNTUNGAN</td>
        </tr>
        
      </tbody>
    </table>

    @php
        $total_infaq = 0;
        $total_item = 0;
        $total_dll = 0;

        $total_qty_infaq = 0;
        $total_qty_item = 0;
        $total_qty_dll = 0;

        $jumlah_hpp = 0;
        $jumlah_omset = 0;
    @endphp
    @for ($count = 0; $count<count($dt_stok); $count++)
    <table border="1px solid" style="font-size: 10px;">
      <thead>
        <tr class="th-atas">
          <th colspan="2" class="text-center" style="background-color: #9BC2E6">{{ $dt_stok[$count]['tanggal'] }}</th>
        </tr>
        <tr class="th-atas">
          <th class="th-middle text-center" style="background-color: #F4B084">Item</th>
          <th class="th-middle text-center" style="background-color: #548235">Total</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach ($dt_stok[$count]['dt_bahan'] as $b)
        <tr>
          <td style="text-align: end;">{{ $b['tot_keluar'] - $b['tot_refund'] }}</td>
          <td style="text-align: end;" >{{ number_format($b['harga'] * ($b['tot_keluar'] - $b['tot_refund']),0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td>=</td>
          <td>=</td>
        </tr>

        @foreach ($dt_kebutuhan[$count]['data_kebutuhan'] as $dk)
        <tr>
          <td style="text-align: end;">{{ $dk['tot_qty'] }}</td>
          <td style="text-align: end;" >{{ number_format($dk['tot_harga'],0) }}</td>
        </tr>
       
        @endforeach

        <tr>
          <td>=</td>
          <td>=</td>
        </tr>

        @foreach ($dt_pengeluaran[$count]['data_pengeluaran'] as $dp)
        <tr>
          @if ($dp['pengeluaran_id'])
          <td style="text-align: end;"><a class="btn-edit-pengeluaran" href="#modal_edit_pengeluaran" data-toggle="modal" pengeluaran_id="{{ $dp['pengeluaran_id'] }}" harga="{{ $dp['harga'] }}" qty="{{ $dp['tot_qty'] }}">{{ $dp['tot_qty'] }}</a></td>
          <td style="text-align: end;"><a class="btn-edit-pengeluaran" href="#modal_edit_pengeluaran" data-toggle="modal" pengeluaran_id="{{ $dp['pengeluaran_id'] }}" harga="{{ $dp['harga'] }}" qty="{{ $dp['tot_qty'] }}">{{ number_format($dp['tot_harga'],0) }}</a></td>
          @else
          <td style="text-align: end;"><a class="btn-input-pengeluaran" href="#modal_input_pengeluaran" data-toggle="modal" tgl="{{ $dp['tgl'] }}" akun_pengeluaran_id="{{ $dp['akun_pengeluaran_id'] }}" harga="{{ $dp['harga'] }}" cabang_id="{{ $dp['cabang_id'] }}">0</a></td>
          <td style="text-align: end;"><a class="btn-input-pengeluaran" href="#modal_input_pengeluaran" data-toggle="modal" tgl="{{ $dp['tgl'] }}" akun_pengeluaran_id="{{ $dp['akun_pengeluaran_id'] }}" harga="{{ $dp['harga'] }}" cabang_id="{{ $dp['cabang_id'] }}">0</a></td>
          @endif
          
        </tr>
       
        @endforeach

        <tr>
          <td style="text-align: end;">{{ $p_semua[$count] }}</td>
          <td style="text-align: end;" >{{ number_format(300 * $p_semua[$count],0) }}</td>
        </tr>

        @php
            $total_item += (300 * $p_semua[$count]);
            $total_qty_item += $p_semua[$count];
        @endphp

        <tr>
          <td style="text-align: end;">{{ $p_infaq[$count] }}</td>
          <td style="text-align: end;" >{{ number_format(400 * $p_infaq[$count],0) }}</td>
        </tr>

        @php
            $total_infaq += (400 * $p_infaq[$count]);
            $total_qty_infaq += $p_infaq[$count];
        @endphp

        <tr>
          <td style="text-align: end;">{{ $p_semua[$count] }}</td>
          <td style="text-align: end;" >{{ number_format(2000 * $p_semua[$count],0) }}</td>
        </tr>

        @php
            $total_dll += (2000 * $p_semua[$count]);
            $total_qty_dll += $p_semua[$count];
        @endphp

        @php
            $jumlah_hpp += ($dt_stok[$count]['tot_bahan'] + $dt_kebutuhan[$count]['tot_kebutuhan'] + $dt_pengeluaran[$count]['tot_pengeluaran'] + (300 * $p_semua[$count]) + (400 * $p_infaq[$count]) + (2000 * $p_semua[$count]));
        @endphp
        
        <tr>
          <td style="text-align: end;">=</td>
          <td style="text-align: end;" >=</td>
        </tr>

        <tr>
          <td style="text-align: end; background-color: #A9D08E;"></td>
          <td style="text-align: end; background-color: #A9D08E;">{{ number_format($dt_stok[$count]['tot_bahan'] + $dt_kebutuhan[$count]['tot_kebutuhan'] + $dt_pengeluaran[$count]['tot_pengeluaran'] + (300 * $p_semua[$count]) + (400 * $p_infaq[$count]) + (2000 * $p_semua[$count]),0) }}</td>
        </tr>

        <tr>
          <td style="text-align: end;">=</td>
          <td style="text-align: end;" >=</td>
        </tr>

        <tr>
          <td style="text-align: end; background-color: #FF0000;"></td>
          <td style="text-align: end; background-color: #FF0000;">{{ number_format($total_omset[$count],0) }}</td>
        </tr>
        @php
            $jumlah_omset += $total_omset[$count];
        @endphp
        <tr>
          <td style="text-align: end; background-color: #8EA9DB;"></td>
          <td style="text-align: end; background-color: #8EA9DB;">{{ number_format($dt_stok[$count]['tot_bahan'] + $dt_kebutuhan[$count]['tot_kebutuhan'] + $dt_pengeluaran[$count]['tot_pengeluaran'] + (300 * $p_semua[$count]) + (400 * $p_infaq[$count]) + (2000 * $p_semua[$count]),0) }}</td>
        </tr>
        <tr>
          <td style="text-align: end; background-color: #A9D08E;"></td>
          <td style="text-align: end; background-color: #A9D08E;">{{ number_format($total_omset[$count] - ($dt_stok[$count]['tot_bahan'] + $dt_kebutuhan[$count]['tot_kebutuhan'] + $dt_pengeluaran[$count]['tot_pengeluaran'] + (300 * $p_semua[$count]) + (400 * $p_infaq[$count]) + (2000 * $p_semua[$count])),0) }}</td>
        </tr>
      </tbody>
    </table>
    @endfor


    

      <table border="1px solid" style="font-size: 10px;">
        <thead>
          <tr>
            <th colspan="2" class="th-atas text-center" style="background-color: #FF0000"><b>AKTUALISASI</b></th>
          </tr>
          <tr>
            <th style="background-color: #F4B084" class="th-middle text-center"><b>ITEM</b></th>
            <th style="background-color: #548235" class="th-middle text-center"><b>TOTAL</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($aktualisasi_bahan as $ab)
          <tr>
            <td><b>{{ $ab['item'] }}</b></td>
            <td><b>{{ number_format($ab['total'],0) }}</b></td>
          </tr>
          @endforeach
          <tr>
            <td>=</td>
            <td>=</td>
          </tr>
          @foreach ($aktualisasi_kebutuhan as $ab)
          <tr>
            <td><b>{{ $ab['item'] }}</b></td>
            <td><b>{{ number_format($ab['total'],0) }}</b></td>
          </tr>
          @endforeach
          <tr>
            <td>=</td>
            <td>=</td>
          </tr>
          @foreach ($aktualisasi_pengeluaran as $ab)
          <tr>
            <td><b>{{ $ab['item'] }}</b></td>
            <td><b>{{ number_format($ab['total'],0) }}</b></td>
          </tr>
          @endforeach

          <tr>
            <td><b>{{ $total_qty_item }}</b></td>
            <td><b>{{ number_format($total_item,0) }}</b></td>
          </tr>

          <tr>
            <td><b>{{ $total_qty_infaq }}</b></td>
            <td><b>{{ number_format($total_infaq,0) }}</b></td>
          </tr>

          <tr>
            <td><b>{{ $total_qty_dll }}</b></td>
            <td><b>{{ number_format($total_dll,0) }}</b></td>
          </tr>

          <tr>
            <td>=</td>
            <td>=</td>
          </tr>

          <tr>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>{{ number_format($jumlah_hpp,0) }}</b></td>
          </tr>

          <tr>
            <td>=</td>
            <td>=</td>
          </tr>

          <tr>
            <td style="background-color: #FF0000"></td>
            <td style="background-color: #FF0000"><b>{{ number_format($jumlah_omset,0) }}</b></td>
          </tr>

          <tr>
            <td style="background-color: #8EA9DB"></td>
            <td style="background-color: #8EA9DB"><b>{{ number_format($jumlah_hpp,0) }}</b></td>
          </tr>

          <tr>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>{{ number_format($jumlah_omset - $jumlah_hpp,0) }}</b></td>
          </tr>

        </tbody>
      </table>


      <table border="1px solid" style="font-size: 10px;">
        <thead>
          <tr>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>STOK AWAL</b></th>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>STOK MASUK</b></th>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>STOK UPDATE</b></th>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>STOK BAKU</b></th>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>STOK ORDER</b></th>
            <th  class="th-atas text-center" style="background-color: #FF0000"><b>TOTAL UANG ORDER</b></th>
          </tr>

          <tr>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
            <th  class="th-middle text-center" style="background-color: #FF0000; color: #FF0000"><b>=</b></th>
          </tr>
          
        </thead>
        <tbody>
          
          @php
              $index = 0;
              $ttl_uang_order = 0;
          @endphp
          @for ($count = 0; $count<count($dt_saldo_awal); $count++)
          @php
              $ada = 0;
          @endphp
          @if ($dt_saldo_awal[$count]['jenis_data'] == 1)
          @php
            $saldo_awal = $dt_saldo_awal[$count]['saldo_awal'];
            $ada++;
          @endphp
          @else
          @php
            $saldo_awal = 0;
          @endphp
          @endif

          @if ($dt_stok_barang[$count]['jenis_data'] == 1)
          @php
            $stok_masuk = $dt_stok_barang[$count]['debit_barang'];
            $ada++;
          @endphp
          @else
          @php
            $stok_masuk = 0;
          @endphp
          @endif

          @if ($dt_stok_baku[$count]['jenis_data'] == 1)
          @php
            $stok_baku = $dt_stok_baku[$count]['stok_baku'];
            $ada++;
          @endphp
          @else
          @php
            $stok_baku = 0;
          @endphp
          @endif

          @if ($ada == 3)
          <tr>
            @if ($saldo_awal != 0)
            <td><b><a href="#modal_edit_saldo_awal" class="edit_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" saldo_awal_id="{{ $dt_saldo_awal[$count]['saldo_awal_id'] }}" saldo_awal="{{ $saldo_awal }}">{{ $saldo_awal }}</a></b></td>
            @else
            <td><b><a href="#modal_input_saldo_awal" class="input_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" >{{ $saldo_awal }}</a></b></td>
            @endif

            <td><b><a href="#modal_stok_barang" class="stok_barang" data-toggle="modal" id_barang="{{ $dt_stok_barang[$count]['id'] }}" jenis_data="{{ $dt_stok_barang[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}">{{ $stok_masuk }}</a></b></td>
            <td><b>{{ $saldo_awal + $stok_masuk - $aktualisasi_bahan[$index]['item'] }}</b></td>
            
            @if ($stok_baku != 0)
            <td><b><a href="#modal_edit_stok_baku" class="edit_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}">{{ $stok_baku }}</a></b></td>
            @else
            <td><b><a href="#modal_input_stok_baku" class="input_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}" stok_baku="{{ $stok_baku }}">{{ $stok_baku }}</a></b></td>
            @endif
            
            <td><b>{{ $stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_bahan[$index]['item']) }}</b></td>
          @php
              $uang_order = ($stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_bahan[$index]['item'])) * $dt_stok_barang[$count]['harga'];
              $ttl_uang_order += $uang_order;
          @endphp
            <td><b>{{ number_format($uang_order,0) }}</b></td>
          </tr>
          @php
              $index ++;
          @endphp
          @else
              @continue
          @endif
          
          
          @endfor


          <tr>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
          </tr>

          @php
              $index = 0;
          @endphp
          @for ($count = 0; $count<count($dt_saldo_awal); $count++)
          @php
              $ada = 0 ;
          @endphp
          @if ($dt_saldo_awal[$count]['jenis_data'] == 2)
          @php
            $saldo_awal = $dt_saldo_awal[$count]['saldo_awal'];
            $ada ++;
          @endphp
          @else
          @php
            $saldo_awal = 0;
          @endphp
          @endif

          @if ($dt_stok_barang[$count]['jenis_data'] == 2)
          @php
            $stok_masuk = $dt_stok_barang[$count]['debit_barang'];
            $ada ++;
          @endphp
          @else
          @php
            $stok_masuk = 0;
          @endphp
          @endif

          @if ($dt_stok_baku[$count]['jenis_data'] == 2)
          @php
            $stok_baku = $dt_stok_baku[$count]['stok_baku'];
            $ada++;
          @endphp
          @else
          @php
            $stok_baku = 0;
          @endphp
          @endif

          @if ($ada == 3)
          <tr>
            @if ($saldo_awal != 0)
            <td><b><a href="#modal_edit_saldo_awal" class="edit_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" saldo_awal_id="{{ $dt_saldo_awal[$count]['saldo_awal_id'] }}" saldo_awal="{{ $saldo_awal }}">{{ $saldo_awal }}</a></b></td>
            @else
            <td><b><a href="#modal_input_saldo_awal" class="input_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" >{{ $saldo_awal }}</a></b></td>
            @endif

            <td><b><a href="#modal_stok_barang" class="stok_barang" data-toggle="modal" id_barang="{{ $dt_stok_barang[$count]['id'] }}" jenis_data="{{ $dt_stok_barang[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}">{{ $stok_masuk }}</a></b></td>
            <td><b>{{ $saldo_awal + $stok_masuk - $aktualisasi_kebutuhan[$index]['item'] }}</b></td>
            
            @if ($stok_baku != 0)
            <td><b><a href="#modal_edit_stok_baku" class="edit_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}">{{ $stok_baku }}</a></b></td>
            @else
            <td><b><a href="#modal_input_stok_baku" class="input_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}" stok_baku="{{ $stok_baku }}">{{ $stok_baku }}</a></b></td>
            @endif
            
            <td><b>{{ $stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_kebutuhan[$index]['item']) }}</b></td>
            @php
              $uang_order = ($stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_kebutuhan[$index]['item'])) * $dt_stok_barang[$count]['harga'];
              $ttl_uang_order += $uang_order;
            @endphp
            <td><b>{{ number_format($uang_order,0) }}</b></td>
          </tr>
          @php
              $index ++;
          @endphp
          @else
              @continue
          @endif
          
          
          @endfor


          <tr>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
          </tr>

         @php
             $index = 0;
         @endphp
          @for ($count = 0; $count<count($dt_saldo_awal); $count++)
          @php
              $ada =0;
          @endphp
          @if ($dt_saldo_awal[$count]['jenis_data'] == 3)
          @php
            $saldo_awal = $dt_saldo_awal[$count]['saldo_awal'];
            $ada ++;
          @endphp
          @else
          @php
            $saldo_awal = 0;
          @endphp
          @endif

          @if ($dt_stok_barang[$count]['jenis_data'] == 3)
          @php
            $stok_masuk = $dt_stok_barang[$count]['debit_barang'];
            $ada ++;
          @endphp
          @else
          @php
            $stok_masuk = 0;
          @endphp
          @endif

          @if ($dt_stok_baku[$count]['jenis_data'] == 3)
          @php
            $stok_baku = $dt_stok_baku[$count]['stok_baku'];
            $ada++;
          @endphp
          @else
          @php
            $stok_baku = 0;
          @endphp
          @endif

          @if ($ada == 3)
          <tr>
            @if ($saldo_awal != 0)
            <td><b><a href="#modal_edit_saldo_awal" class="edit_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" saldo_awal_id="{{ $dt_saldo_awal[$count]['saldo_awal_id'] }}" saldo_awal="{{ $saldo_awal }}">{{ $saldo_awal }}</a></b></td>
            @else
            <td><b><a href="#modal_input_saldo_awal" class="input_saldo_awal" data-toggle="modal" id_barang="{{ $dt_saldo_awal[$count]['id'] }}" jenis_data="{{ $dt_saldo_awal[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}" >{{ $saldo_awal }}</a></b></td>
            @endif

            <td><b><a href="#modal_stok_barang" class="stok_barang" data-toggle="modal" id_barang="{{ $dt_stok_barang[$count]['id'] }}" jenis_data="{{ $dt_stok_barang[$count]['jenis_data'] }}" nm_item="{{ $dt_saldo_awal[$count]['nm_item'] }}">{{ $stok_masuk }}</a></b></td>
            <td><b>{{ $saldo_awal + $stok_masuk - $aktualisasi_pengeluaran[$index]['item'] }}</b></td>
            
            @if ($stok_baku != 0)
            <td><b><a href="#modal_edit_stok_baku" class="edit_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}">{{ $stok_baku }}</a></b></td>
            @else
            <td><b><a href="#modal_input_stok_baku" class="input_stok_baku" data-toggle="modal" id_barang="{{ $dt_stok_baku[$count]['id'] }}" jenis_data="{{ $dt_stok_baku[$count]['jenis_data'] }}" nm_item="{{ $dt_stok_baku[$count]['nm_item'] }}" stok_baku_id="{{ $dt_stok_baku[$count]['stok_baku_id'] }}" stok_baku="{{ $stok_baku }}">{{ $stok_baku }}</a></b></td>
            @endif
            
            <td><b>{{ $stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_pengeluaran[$index]['item']) }}</b></td>
            
            @php
              $uang_order = ($stok_baku - ($saldo_awal + $stok_masuk - $aktualisasi_pengeluaran[$index]['item'])) * $dt_stok_barang[$count]['harga'];
              $ttl_uang_order += $uang_order;
            @endphp
            <td><b>{{ number_format($uang_order,0) }}</b></td>
          </tr>

          @php
              $index ++;
          @endphp
          @else
              @continue
          @endif
          @endfor
          

          <tr>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
          </tr>

          <tr>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
          </tr>

          <tr>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
            <td><b>-</b></td>
          </tr>

          <tr>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
          </tr>

          <tr>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"><b>{{ number_format($ttl_uang_order,0) }}</b></td>
          </tr>

          <tr>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
            <td>=</td>
          </tr>

          <tr>
            <td style="background-color: #FF0000"></td>
            <td style="background-color: #FF0000"><b>-</b></td>
            <td style="background-color: #FF0000"></td>
            <td style="background-color: #FF0000"><b>-</b></td>
            <td style="background-color: #FF0000"><b>-</b></td>
            <td style="background-color: #FF0000"><b>-</b></td>
          </tr>

          <tr>
            <td style="background-color: #8EA9DB"></td>
            <td style="background-color: #8EA9DB"><b>-</b></td>
            <td style="background-color: #8EA9DB"></td>
            <td style="background-color: #8EA9DB"><b>-</b></td>
            <td style="background-color: #8EA9DB"><b>-</b></td>
            <td style="background-color: #8EA9DB"><b>-</b></td>
          </tr>

          <tr>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
            <td style="background-color: #A9D08E"><b>-</b></td>
          </tr>

        </tbody>
      </table>

  </div>