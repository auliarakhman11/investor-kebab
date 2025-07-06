
<div class="scroll_horizontal">
    <table border="1px solid" style="white-space: nowrap;position: sticky; left: 0; z-index: 999; font-size: 10px;">
      <thead>
        <tr>
          <th class="th-atas text-center" style="background-color: #757171">Menu</th>
          <th class="th-atas text-center" style="background-color: #A9D08E">Harga</th>

        </tr>
        <tr>
          <th class="th-middle" colspan="2" style="color: white; background-color: white;">1</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($produk as $p)
        
        <tr>
          <td style="background-color: white;">{{ $p->nm_produk }}</td>
          <td style="background-color: white; text-align: end;" >{{ number_format($p->harga_normal,0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td colspan="2" style="background-color: #FF0000;" class="text-center"><b>TOTAL OMSET</b></td>
        </tr>
        
        @foreach ($pembayaran as $p)
        <tr>
          <td style="background-color: white;"></td>
          <td style="background-color: white;">{{ $p->pembayaran }}</td>
        </tr>
        @endforeach

        <tr>
          <td colspan="2" style="background-color: #FF0000;" class="text-center"><b>TOTAL PEMBAYARAN</b></td>
        </tr>
        
      </tbody>
    </table>

    @foreach ($dt_penjualan as $d)
    <table border="1px solid" style="font-size: 10px;">
      <thead>
        <tr class="th-atas">
          <th colspan="2" class="text-center" style="background-color: #9BC2E6">{{ $d['tanggal'] }}</th>
        </tr>
        <tr class="th-atas">
          <th class="th-middle text-center" style="background-color: #F4B084">Item</th>
          <th class="th-middle text-center" style="background-color: #548235">Total</th>
        </tr>
      </thead>
      <tbody>
        @php
        $id_produk = 0;
        $jml_id_produk = 0;
        @endphp
        @foreach ($d['penjualan'] as $p)
        @if ($id_produk != $p['produk_id'])
            @php
                $id_produk = $p['produk_id'];
                $jml_id_produk ++;
            @endphp
        @endif
        <tr>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }}; text-align: end;">{{ $p['qty'] }}</td>
          <td style="background-color: {{ $jml_id_produk % 2 == 0 ? 'white' : 'grey' }}; text-align: end;" >{{ number_format($p['tot'],0) }}</td>
        </tr>
       
        @endforeach

        <tr>
          <td style="background-color: #FF0000;"></td>
          <td style="background-color: #FF0000; text-align: end;" ><b>{{ number_format($d['tot_omset'],0) }}</b></td>
        </tr>

        @foreach ($d['dt_pembayaran'] as $pm)
        <tr>
          <td ></td>
          <td style="background-color: #A9D08E; text-align: end;" >{{ number_format($pm['tot'],0) }}</td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: #FF0000"></td>
          <td style="background-color: #FF0000; text-align: end;" ><b>{{ number_format($d['tot_pembayaran'],0) }}</b></td>
        </tr>

        
        
      </tbody>
    </table>

    @endforeach

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
        @foreach ($aktualisasi_p as $ap)
        <tr>
          <td><b>{{ $ap['item'] }}</b></td>
          <td><b>{{ number_format($ap['total'],0) }}</b></td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: #FF0000;">-</td>
          <td style="background-color: #FF0000;">-</td>
        </tr>

        @foreach ($aktualisasi_pm as $apm)
        <tr>
          <td><b>{{ $apm['item'] }}</b></td>
          <td><b>{{ number_format($apm['total'],0) }}</b></td>
        </tr>
        @endforeach

        <tr>
          <td style="background-color: #FF0000;">-</td>
          <td style="background-color: #FF0000;">-</td>
        </tr>
      </tbody>
    </table>