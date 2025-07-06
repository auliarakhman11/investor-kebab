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
            <th class="th-atas">Penjualan</th>
            <th class="th-atas">Gapok</th>
            <th class="th-atas">Persen</th>
            <th class="th-atas">Persen<br>Penjualan</th>
            <th class="th-atas">Kasbon</th>
            <th class="th-atas">THP</th>
            <th class="th-atas">Print</th>
        </tr>
        </thead>
        <tbody>
            {{-- <input type="hidden" name="tgl1" value="{{ $tgl1 }}">
            <input type="hidden" name="tgl2" value="{{ $tgl2 }}"> --}}
            
            @foreach ($dt_gaji as $d)
            <tr>
                {{-- <input type="hidden" id="total_gaji_persen{{ $d->id }}" name="gaji_persen[]">
                <input type="hidden" id="kasbon{{ $d->id }}" name="kasbon[]" value="{{ $d->jml_kasbon }}">
                <input type="hidden" id="thp{{ $d->id }}">
                <input type="hidden" name="karyawan_id[]" value="{{ $d->id }}">
                <input type="hidden" name="kota_id[]" value="{{ $d->kota_id }}"> --}}
                <td><strong>{{ $d->nama }}</strong></td>
                <td class="text-center">{{ number_format($d->pendapatan,0) }}
                {{-- <input type="hidden" name="pendapatan[]" id="pendapatan{{ $d->id }}" value="{{ $d->jml_penjualan }}"> --}}
                </td>
                <td class="text-center">{{ number_format($d->gapok,0) }}
                    {{-- <input type="hidden" id="gapok{{ $d->id }}" name="gapok[]" value="{{ $d->jml_gapok }}"> --}}
                </td>
                <td>{{ $d->persen }}%</td>
                <td class="total_gaji_persen">{{ number_format($d->gaji_persen,0) }}</td>
                <td class="text-center">{{ number_format($d->kasbon,0) }}</td>
                <td class="thp">
                   {{ number_format($d->gaji_persen + $d->gapok - $d->kasbon,0) }}
                </td>
                <td><a href="{{ route('printGajiOffice',['id' => $d->id]) }}" class="btn btn-info btn-xs"><i class="fas fa-print"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>