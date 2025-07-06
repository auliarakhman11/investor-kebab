
<style>
    .th-atas {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top:0;
      background-color: grey;
      color: white;
		}
</style>

    <table class="table table-sm table-striped table-bordered" width="100%">
        <thead class="text-center">
        <tr>
            <th class="th-atas">Karyawan</th>
            <th class="th-atas">Gapok</th>
            <th class="th-atas">Penjualan</th>
            <th class="th-atas">Persen</th>
            <th class="th-atas">Pendapatan<br>Persen</th>
            <th class="th-atas">Kasbon</th>
            <th class="th-atas">THP</th>
        </tr>
        </thead>
        <tbody>
            <input type="hidden" name="tgl1" value="{{ $tgl1 }}">
            <input type="hidden" name="tgl2" value="{{ $tgl2 }}">
            
            @foreach ($dt_gaji as $d)
            @php
                $pendapatan_persen = $d->persen ? $d->ttl_penjualan * $d->persen / 100 : 0;
            @endphp
            <tr>
                <input type="hidden" name="karyawan_id[]" value="{{ $d->id }}">
                <td>{{ $d->nama }}</td>
                <td>{{ number_format($d->ttl_gapok,0) }}
                <input type="hidden" name="gapok[]" value="{{ $d->ttl_gapok }}">
                </td>
                <td>{{ number_format($d->ttl_penjualan,0) }}
                    <input type="hidden" name="pendapatan[]" value="{{ $d->ttl_penjualan }}">
                </td>
                <td>{{ $d->persen }}%
                    <input type="hidden" name="persen[]" value="{{ $d->persen }}">
                </td>
                <td>{{ number_format( $pendapatan_persen,0) }}
                    <input type="hidden" name="gaji_persen[]" value="{{ $pendapatan_persen }}">
                </td>
                <td>{{ $d->jml_kasbon }}
                    <input type="hidden" name="jml_kasbon[]" value="{{ $d->jml_kasbon }}">
                </td>
                <td>{{ number_format($d->ttl_gapok + $pendapatan_persen - $d->jml_kasbon,0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
