<h5>Gaji Crew</h5>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Periode</th>
            <th>Gapok</th>
            <th>Gaji Persen</th>
            <th>Kasbon</th>
            <th>THP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dt_gaji as $d)
        <tr>
            <td>{{ date("d M Y", strtotime($d->tgl1)) }} ~ {{ date("d M Y", strtotime($d->tgl2)) }}</td>
            <td>{{ number_format($d->ttl_gapok,0) }}</td>
            <td>{{ number_format($d->ttl_gaji_persen,0) }}</td>
            <td>{{ number_format($d->ttl_kasbon,0) }}</td>
            <td>{{ number_format($d->ttl_gapok + $d->ttl_gaji_persen - $d->ttl_kasbon,0) }}</td>
            <td>
                <button class="btn btn-xs btn-danger delete_list_gaji" kd_gabungan="{{ $d->kd_gabungan }}"><i class="fas fa-trash"></i></button>
                <button class="btn btn-xs btn-info edit_list_gaji" data-target="#modal_edit_list_gaji" data-toggle="modal" kd_gabungan="{{ $d->kd_gabungan }}"><i class="fas fa-search"></i></button>
            </td>
        </tr>
        @endforeach        
    </tbody>
</table>