
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
            <th class="th-atas">Jumlah<br>Ceklis</th>
            <th class="th-atas" colspan="2">Jumlah<br>Masuk</th>
            <th class="th-atas">Persen<br>Penjualan</th>
            <th class="th-atas">Persen<br>Kinerja</th>
            <th class="th-atas">Total<br>Persen</th>
            <th class="th-atas">Gaji<br>Persen</th>
            <th class="th-atas">Kasbon</th>
            <th class="th-atas">THP</th>
        </tr>
        </thead>
        <tbody>
            <input type="hidden" name="tgl1" value="{{ $tgl1 }}">
            <input type="hidden" name="tgl2" value="{{ $tgl2 }}">
            
            @foreach ($dt_gaji as $d)
            <tr>
                <input type="hidden" id="total_gaji_persen{{ $d->id }}" name="gaji_persen[]">
                <input type="hidden" id="kasbon{{ $d->id }}" name="kasbon[]" value="{{ $d->jml_kasbon }}">
                <input type="hidden" id="thp{{ $d->id }}">
                <input type="hidden" name="karyawan_id[]" value="{{ $d->id }}">
                <input type="hidden" name="kota_id[]" value="{{ $d->kota_id }}">
                <td><strong>{{ $d->nama }}</strong></td>
                <td class="text-center">{{ number_format($d->jml_penjualan,0) }}
                <input type="hidden" name="pendapatan[]" id="pendapatan{{ $d->id }}" value="{{ $d->jml_penjualan }}">
                </td>
                <td class="text-center">{{ number_format($d->jml_gapok,0) }}
                    <input type="hidden" id="gapok{{ $d->id }}" name="gapok[]" value="{{ $d->jml_gapok }}">
                </td>
                <td class="{{ $d->jml_audit > 2 ? 'text-danger' : '' }} text-center">{{ $d->jml_audit }}
                    <input type="hidden" name="audit[]" value="{{ $d->jml_audit }}">
                </td>
                <td>{{ $d->jml_masuk }}</td>
                <td>Leader : {{ $d->jml_leader }}<br>
                    Rolling : {{ $d->jml_rolling }}<br>
                    MS : {{ $d->jml_ms }}

                    <input type="hidden" name="leader[]" value="{{ $d->jml_leader }}">
                    <input type="hidden" name="rolling[]" value="{{ $d->jml_rolling }}">
                    <input type="hidden" name="ms[]" value="{{ $d->jml_ms }}">
                </td>
                <td width="10%"><input type="number" class="form-control form-control-sm persen" id="persen1{{ $d->id }}" karyawan_id="{{ $d->id }}" name="persen1[]" ></td>
                <td width="10%"><input type="number" class="form-control form-control-sm persen" id="persen2{{ $d->id }}" karyawan_id="{{ $d->id }}" name="persen2[]"></td>
                <td id="total_persen{{ $d->id }}"></td>
                <td width="10%" class="total_gaji_persen{{ $d->id }}"></td>
                <td width="10%" class="text-center">{{ number_format($d->jml_kasbon,0) }}</td>
                <td width="10%" class="thp{{ $d->id }}">
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
