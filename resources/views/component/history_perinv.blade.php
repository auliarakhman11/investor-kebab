<table class="table table-sm">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No Invoice</th>            
            <th>Mitra/Outlet</th>
            <th>Total</th>
            <th>Print</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dt_jurnal as $d)
        <tr>
            <td>{{ date("d M Y", strtotime($d->tgl)) }}</td>
            <td>{{ $d->kode_inv }}</td>
            <td>
                @if ($d->mitra)
                    {{ $d->mitra->nm_mitra }}
                @endif

                @if ($d->kota)
                    {{ $d->kota->nm_kota }}
                @endif
            </td>
            <td>{{ number_format($d->ttl_kredit,0) }}</td>
            <td><a href="{{ route('printInvoice',$d->kode_inv) }}" class="btn btn-xs btn-primary"><i class="fas fa-print"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>