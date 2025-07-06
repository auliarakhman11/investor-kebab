<style>
    /* .scroll_horizontal {
      overflow-x: auto;
      white-space: nowrap;
    } */
  
    div.scroll_horizontal {
        overflow-y: scroll;
        overflow-x: auto;
        white-space: nowrap;
        height:400px;
    }
  
    div.scroll_horizontal table {
        display: inline-block;
        
    }

    div.scroll_horizontal_minuman {
        overflow-y: scroll;
        overflow-x: auto;
        white-space: nowrap;
    }
  
    div.scroll_horizontal_minuman table {
        display: inline-block;
        
    }

    /* .scroll_table {
    overflow-x: auto;
    height:600px;
    overflow-y: scroll;
    }

    div.scroll_horizontal table {
        display: inline-block;
        
    } */

    .th-atas {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top:0;
		}

    .th-middle {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top: 25px;
		}


  </style>

<div class="scroll_horizontal">
<h5>Rekapitulasi Penjulaan Makanan</h5>
    @php
        $i=1;
        $total_peritem = [];
    @endphp
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: white">#</th>
          <th class="th-atas" style="background-color: #BDD7EE">Nama Item</th>
          <th class="th-atas" style="background-color: #C6E0B4">Harga</th>
          <th class="th-atas" style="background-color: #C6E0B4">Pembayaran</th>

        </tr>
        <tr>
          <th class="th-middle" colspan="4" style="color: white; background-color: white;">1</th>
        </tr>
      </thead>
      <tbody>
        @php
            $id_produk = 0;
            $jml_id_produk = 0;
        @endphp
        @foreach ($dt_produk as $d)
        @if ($d->kategori_id != 4)
            @if ($id_produk != $d->id)
            @php
                $id_produk = $d->id;
                $jml_id_produk ++;
            @endphp
            @endif
            
        @php
            $noi = 1;
        @endphp
        @foreach ($dt_pembayaran as $dp)
        <tr>
        @if ($noi == 1)
        
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};" rowspan="{{ $count_pembayaran }}">{{ $i++ }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }}" rowspan="{{ $count_pembayaran }}">{{ $d->nm_produk }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};"  rowspan="{{ $count_pembayaran }}">{{ $d->harga_jual }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};" >{{ $dp->pembayaran }}</td>
                    
        @else
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};" >{{ $dp->pembayaran }}</td>        
        @endif
      </tr>
        @php
            $noi++;
        @endphp
        @endforeach  

        @endif              
        @endforeach
        <tr>
          <td style="background-color: white;" colspan="4">Total</td>
        </tr>
        <tr>
          <td style="background-color: white;" colspan="4">Infaq</td>
        </tr>
        <tr>
          <td style="background-color: white;" colspan="4">Item</td>
        </tr>
        <tr>
          <td style="background-color: white;" colspan="4">Beban Dll</td>
        </tr>
      </tbody>
    </table>
    @php
        $ttl_penjualan = 0;
        $ttl_infaq = 0;
        $ttl_item = 0;
        $ttl_beban_dll = 0;
        $ttl_qty = 0;
        $ttl_qty_infaq = 0;

    @endphp

    
    @foreach ($dt_penjualan_produk as $dp)
    @php
        $total_p = 0;
        $total_q = 0;
        $infaq = 0;
    @endphp
    <table border="1px solid">
      <thead>
        <tr class="th-atas">
          <th colspan="2" style="background-color: #AEAAAA">{{ $dp['nm_cabang'] }}</th>
        </tr>
        <tr class="th-atas">
          <th class="th-middle" style="background-color: #FFC000">Item</th>
          <th class="th-middle" style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @php
        $id_produk = 0;
        $jml_id_produk = 0;
        @endphp
        @foreach ($dp['penjualan'] as $p)
        @if ($id_produk != $p['produk_id'])
            @php
                $id_produk = $p['produk_id'];
                $jml_id_produk ++;
            @endphp
        @endif
        <tr>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};">{{ $p['terjual'] }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};">{{ number_format($p['jml_penjualan'],0) }}</td>
        </tr>
        @php
            $total_p += $p['jml_penjualan'];
            $total_q += $p['terjual'];
        @endphp
        @if ($p['kategori_id'] == 1 || $p['kategori_id'] == 2)
            @php
                $infaq += $p['terjual'];
            @endphp
        @endif
        @endforeach
        <tr>
          <td style="background-color: #FFC000">{{ $total_q }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($total_p,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $infaq }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($infaq * 200,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $total_q }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($total_q * 300,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $total_q }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($total_q * 1500,0) }}</td>
        </tr>
      </tbody>
    </table>

    @php
        $ttl_penjualan += $total_p;
        $ttl_infaq += ($infaq * 200);
        $ttl_item += ($total_q * 300);
        $ttl_beban_dll += ($total_q * 1500);
        $ttl_qty += $total_q;
        $ttl_qty_infaq += $infaq;
    @endphp
    @endforeach

    <table border="1px solid">
      <thead>
        <tr class="th-atas">
          <th colspan="2" style="background-color: #FF0000">Total</th>
        </tr>
        <tr class="th-middle">
          <th style="background-color: #FFC000">Item</th>
          <th style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @php
        $id_produk = 0;
        $jml_id_produk = 0;
        @endphp
        @foreach ($total_pn as $tpn)
        @if ($id_produk != $tpn['produk_id'])
            @php
                $id_produk = $tpn['produk_id'];
                $jml_id_produk ++;
            @endphp
        @endif
        <tr>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};">{{ $tpn['sub_qty'] }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }};">{{ number_format($tpn['subtotal'],0) }}</td>
        </tr>
        @endforeach
        <tr>
          <td style="background-color: #FFC000">{{ $ttl_qty }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($ttl_penjualan,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $ttl_qty_infaq }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($ttl_infaq,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $ttl_qty }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($ttl_item,0) }}</td>
        </tr>
        <tr>
          <td style="background-color: #FFC000">{{ $ttl_qty }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($ttl_beban_dll,0) }}</td>
        </tr>
        
      </tbody>
    </table>

  </div>

  <div class="scroll_horizontal_minuman mt-2">
    <hr>
    <h5>Rekapitulasi Penjulaan Minuman</h5>
    @php
        $i=1;
    @endphp
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: white">#</th>
          <th class="th-atas" style="background-color: #BDD7EE">Nama Item</th>
          <th class="th-atas" style="background-color: #C6E0B4">Harga</th>
          <th class="th-atas" style="background-color: #C6E0B4">Pembayaran</th>

        </tr>
        <tr>
          <th class="th-middle" colspan="4" style="color: white; background-color: white;">1</th>
          
        </tr>
      </thead>
      <tbody>
        @foreach ($dt_produk as $d)
        @if ($d->kategori_id == 4)
            
        @php
            $noi = 1;
        @endphp
        @foreach ($dt_pembayaran as $dp)
        <tr>
        @if ($noi == 1)
        
          <td style="background-color: white;" rowspan="{{ $count_pembayaran_minuman }}">{{ $i++ }}</td>
          <td style="background-color: white;" rowspan="{{ $count_pembayaran_minuman }}">{{ $d->nm_produk }}</td>
          <td style="background-color: white;"  rowspan="{{ $count_pembayaran_minuman }}">{{ $d->harga_jual }}</td>
          <td style="background-color: white;" >{{ $dp->pembayaran }}</td>
                    
        @else
          <td style="background-color: white;" >{{ $dp->pembayaran }}</td>        
        @endif
      </tr>
      
        @php
            $noi++;
        @endphp
        @endforeach

        @endif                
        @endforeach
        <tr>
          <td style="background-color: white;" colspan="4">Total</td>
        </tr>
      </tbody>
    </table>

    @php
        $tot_qty = 0;
        $tot_penjualan = 0;
    @endphp

    @foreach ($dt_penjualan_minuman as $dp)
    @php
        $ttl_qty = 0;
        $ttl_penjualan = 0;
    @endphp
    <table border="1px solid">
      <thead>
        <tr class="th-atas">
          <th colspan="2" style="background-color: #AEAAAA">{{ $dp['nm_cabang'] }}</th>
        </tr>
        <tr class="th-atas">
          <th class="th-middle" style="background-color: #FFC000">Item</th>
          <th class="th-middle" style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dp['penjualan'] as $p)
        @php
            $ttl_qty += $p['terjual'];
            $ttl_penjualan += $p['jml_penjualan'];
        @endphp
        <tr>
          <td>{{ $p['terjual'] }}</td>
          <td>{{ number_format($p['jml_penjualan'],0) }}</td>
        </tr>
        @endforeach
        <tr>
          <td style="background-color: #FFC000">{{ $ttl_qty }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($ttl_penjualan,0) }}</td>
        </tr>

        @php
            $tot_qty += $ttl_qty;
            $tot_penjualan += $ttl_penjualan;
        @endphp

      </tbody>
    </table>

    @endforeach

    <table border="1px solid">
      <thead>
        <tr class="th-atas">
          <th colspan="2" style="background-color: #FF0000">Total</th>
        </tr>
        <tr class="th-middle">
          <th style="background-color: #FFC000">Item</th>
          <th style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($total_mn as $tpn)
        <tr>
          <td>{{ $tpn['sub_qty'] }}</td>
          <td>{{ number_format($tpn['subtotal'],0) }}</td>
        </tr>
        @endforeach
        <tr>
          <td style="background-color: #FFC000">{{ $tot_qty }}</td>
          <td style="background-color: #C6E0B4">{{ number_format($tot_penjualan,0) }}</td>
        </tr>
        
        
      </tbody>
    </table>

  </div>



  <div class="scroll_horizontal mt-2">
    <hr>
    <h5>Total Global</h5>
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th colspan="3">Total Makanan</th>
        </tr>
        <tr>
          <th class="th-atas" style="background-color: white;">Pembayaran</th>
          <th class="th-atas" style="background-color: #FFC000">Item</th>
          <th class="th-atas" style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @php
            $tot_qty = 0;
            $tot_uang = 0;
        @endphp
        @foreach ($total_global as $d)
        <tr>
          <td>{{ $d['pembayaran'] }}</td>
          <td >{{ $d['ttl_qty'] }}</td>
          <td >{{ number_format($d['ttl_uang'],0) }}</td>
        </tr>
        @php
            $tot_qty += $d['ttl_qty'];
            $tot_uang += $d['ttl_uang'];
        @endphp
        @endforeach
        <tr>
          <td><b>Total</b></td>
          <td><b>{{ $tot_qty }}</b></td>
          <td><b>{{ number_format($tot_uang,0) }}</b></td>
        </tr>
      </tbody>
    </table>

    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th colspan="3">Total Minuman</th>
        </tr>
        <tr>
          <th class="th-atas" style="background-color: white;">Pembayaran</th>
          <th class="th-atas" style="background-color: #FFC000">Item</th>
          <th class="th-atas" style="background-color: #C6E0B4">Uang</th>
        </tr>
      </thead>
      <tbody>
        @php
            $tot_qty = 0;
            $tot_uang = 0;
        @endphp
        @foreach ($total_global_minuman as $d)
        <tr>
          <td>{{ $d['pembayaran'] }}</td>
          <td >{{ $d['ttl_qty'] }}</td>
          <td >{{ number_format($d['ttl_uang'],0) }}</td>
        </tr>
        @php
            $tot_qty += $d['ttl_qty'];
            $tot_uang += $d['ttl_uang'];
        @endphp
        @endforeach
        <tr>
          <td><b>Total</b></td>
          <td><b>{{ $tot_qty }}</b></td>
          <td><b>{{ number_format($tot_uang,0) }}</b></td>
        </tr>
      </tbody>
    </table>

  </div>



  <div class="scroll_horizontal mt-2">
    <hr>
    <h5>Rekapitulasi Stok Bahan</h5>
    @php
        $i=1;
    @endphp
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: white;">#</th>
          <th class="th-atas" style="background-color: #BDD7EE">Bahan</th>
        </tr>
        <tr>
          <th class="th-middle" colspan="2" style="color:white; background-color: white">1</th>
        </tr>
      </thead>
      <tbody style="background-color: white">
        @php
            $bahan_id = 0;
            $ttl_bahan_id = 0;
        @endphp
        @foreach ($dt_bahan as $d)
        @if ($d->id != $bahan_id)
        @php
            $bahan_id = $d->id;
            $ttl_bahan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }};">{{ $i++ }}</td>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }};">{{ $d->bahan }}</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="2"><strong>Total</strong></td>
        </tr>
      </tbody>
    </table>

    @php
        $total_b = 0;
        $total_l = 0;
        $total_s = 0;
    @endphp
    @foreach ($dt_penjualan_bahan as $dp)
    <table border="1px solid">
      <thead>
        <tr>
          <th class="th-atas" colspan="3" style="background-color: #AEAAAA">{{ $dp['nm_cabang'] }}</th>
        </tr>
        <tr>
          <th class="th-middle" style="background-color: #FFC000; width: 50px;">B</th>
          <th class="th-middle" style="background-color: #FF0000; width: 50px;">L</th>
          <th class="th-middle" style="background-color: #C6E0B4; width: 50px;">S</th>
        </tr>
      </thead>
      <tbody>
        @php
            $ttl_b = 0;
            $ttl_l = 0;
            $ttl_s = 0;
        @endphp
        @php
            $bahan_id = 0;
            $ttl_bahan_id = 0;
        @endphp
        @foreach ($dp['stok'] as $p)
        @if ($p['bahan_id'] != $bahan_id)
        @php
            $bahan_id = $p['bahan_id'];
            $ttl_bahan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $p['total_bawa'] }}</td>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $p['total_bawa'] - ($p['debit'] - $p['kredit']) }}</td>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $p['debit'] - $p['kredit'] }}</td>
        </tr>
        @php
            $ttl_b += $p['total_bawa'];
            $ttl_l += ( $p['total_bawa'] - ($p['debit'] - $p['kredit']) );
            $ttl_s += ( $p['debit'] - $p['kredit'] );
        @endphp
        @endforeach
        <tr>
          <td style="background-color: #FFC000; text-align: center;">{{ $ttl_b }}</td>
          <td style="background-color: #FF0000; text-align: center;">{{ $ttl_l }}</td>
          <td style="background-color: #C6E0B4; text-align: center;">{{ $ttl_s }}</td>
        </tr>
      </tbody>
    </table>
    @php
        $total_b += $ttl_b;
        $total_l += $ttl_l;
        $total_s += $ttl_s;
    @endphp
    @endforeach

    <table border="1px solid">
      <thead>
        <tr>
          <th class="th-atas" colspan="3" style="background-color: #AEAAAA"><strong>Total</strong></th>
        </tr>
        <tr>
          <th class="th-middle" style="background-color: #FFC000">B</th>
          <th class="th-middle" style="background-color: #FF0000">L</th>
          <th class="th-middle" style="background-color: #C6E0B4">S</th>
        </tr>
      </thead>
      <tbody>
        @php
            $ttl_b = 0;
            $ttl_l = 0;
            $ttl_s = 0;
        @endphp
        @php
            $bahan_id = 0;
            $ttl_bahan_id = 0;
        @endphp
        @foreach ($total_bahan as $tb)
        @if ($tb['bahan_id'] != $bahan_id)
        @php
            $bahan_id = $tb['bahan_id'];
            $ttl_bahan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $tb['total_bawa'] }}</td>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $tb['laku'] }}</td>
          <td style="background-color: {{ $ttl_bahan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $tb['sisa'] }}</td>
        </tr>
        @endforeach
        <tr>
          <td style="background-color: #FFC000; text-align: center;">{{ $total_b }}</td>
          <td style="background-color: #FF0000; text-align: center;">{{ $total_l }}</td>
          <td style="background-color: #C6E0B4; text-align: center;">{{ $total_s }}</td>
        </tr>
      </tbody>
    </table>

  </div>


  <div class="scroll_horizontal mt-2">
    <hr>
    <h5>Rekapitulasi Barang Kebutuhan</h5>
    @php
        $i=1;
    @endphp
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999;">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: white;">#</th>
          <th class="th-atas" style="background-color: #BDD7EE">Barang</th>
        </tr>
        <tr>
          <th class="th-middle" colspan="2" style="color:white; background-color: white">1</th>
        </tr>
      </thead>
      <tbody style="background-color: white">
        @php
            $barang_kebutuhan_id = 0;
            $ttl_barang_kebutuhan_id = 0;
        @endphp
        @foreach ($dt_barang_kebutuhan as $d)
        @if ($d->id != $barang_kebutuhan_id)
        @php
            $barang_kebutuhan_id = $d->id;
            $ttl_barang_kebutuhan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_barang_kebutuhan_id % 2 == 0 ? 'white' : 'grey' }};">{{ $i++ }}</td>
          <td style="background-color: {{ $ttl_barang_kebutuhan_id % 2 == 0 ? 'white' : 'grey' }};">{{ $d->nm_barang }}</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="2"><strong>Total</strong></td>
        </tr>
      </tbody>
    </table>

    
    @foreach ($dt_kebutuhan_cabang as $dk)
    <table border="1px solid">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: #AEAAAA">{{ $dk['nm_cabang'] }}</th>
        </tr>
        <tr>
          <th class="th-middle text-center" style="background-color: #FFC000;">Qty</th>
        </tr>
      </thead>
      <tbody>
        @php
            $ttl_qty = 0;
        @endphp
        @php
            $barang_kebutuhan_id = 0;
            $ttl_barang_kebutuhan_id = 0;
        @endphp
        @foreach ($dk['kebututuhan_cabang'] as $p)
        @if ($p['barang_kebutuhan_id'] != $barang_kebutuhan_id)
        @php
            $barang_kebutuhan_id = $p['barang_kebutuhan_id'];
            $ttl_barang_kebutuhan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_barang_kebutuhan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $p['banyak'] }}</td>
        </tr>
        @php
            $ttl_qty += $p['banyak'];
        @endphp
        @endforeach
        <tr>
          <td style="background-color: #FFC000; text-align: center;">{{ $ttl_qty }}</td>
        </tr>
      </tbody>
    </table>
    @endforeach

    <table border="1px solid">
      <thead>
        <tr>
          <th class="th-atas" style="background-color: #AEAAAA"><strong>Total</strong></th>
        </tr>
        <tr>
          <th class="th-middle" style="background-color: #AEAAAA;">Barang</th>
        </tr>
      </thead>
      <tbody>
        @php
            $ttl_qty = 0;
        @endphp
        @php
            $barang_kebutuhan_id = 0;
            $ttl_barang_kebutuhan_id = 0;
        @endphp
        @foreach ($total_br as $tb)
        @if ($tb['barang_kebutuhan_id'] != $barang_kebutuhan_id)
        @php
            $barang_kebutuhan_id = $tb['barang_kebutuhan_id'];
            $ttl_barang_kebutuhan_id ++;
        @endphp
        @endif
        <tr>
          <td style="background-color: {{ $ttl_barang_kebutuhan_id % 2 == 0 ? 'white' : 'grey' }}; text-align: center;">{{ $tb['ttl_banyak'] }}</td>
        </tr>
        @php
            $ttl_qty += $tb['ttl_banyak'];
        @endphp
        @endforeach
        <tr>
          <td style="background-color: #FFC000; text-align: center;">{{ $ttl_qty }}</td>
        </tr>
      </tbody>
    </table>


  </div>