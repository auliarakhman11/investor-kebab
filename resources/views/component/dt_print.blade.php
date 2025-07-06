<style>
    .th-atas {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top:0;
		}
</style>
<table class="table table-striped" id="table">
    <thead>
      <tr>
        <th class="th-atas" style="background-color: white;">#</th>
        <th class="th-atas" style="background-color: white;">Outlet</th>
        {{-- <th class="th-atas" style="background-color: white;">No Invoice</th> --}}
        <th class="th-atas" style="background-color: white;">Penjual</th>
        <th class="th-atas" style="background-color: white;">Produk</th>
        <th class="th-atas" style="background-color: white;">Total</th>
        <th class="th-atas" style="background-color: white;">Order</th>
        <th class="th-atas" style="background-color: white;">Pembayaran</th>
        <th class="th-atas" style="background-color: white;">Waktu</th>
        <th class="th-atas" style="background-color: white;">Print</th>
      </tr>
    </thead>
    @php
        $i = 1;
    @endphp
    <tbody>
      @foreach ($print as $pr)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $pr->cabang->nama }}</td>
        {{-- <td>{{ $pr->no_invoice }}</td> --}}
        <td>
          @foreach ($pr->getPenjualanKaryawan as $kr)
              {{ $kr->karyawan->nama }},
          @endforeach
        </td>
        <td>
          @foreach ($pr->getPenjualan as $pn)
              {{ $pn->produk->nm_produk }} X {{ $pn->qty }}
          @endforeach
        </td>
        <td>{{ number_format($pr->total) }}</td>
        <td>{{ $pr->delivery->delivery }}</td>
        <td>{{ $pr->pembayaran->pembayaran }}</td>
        <td>{{ date("d M Y H:i:s", strtotime($pr->created_at)) }}</td>
        <td>{{ $pr->print }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>