<table class="table table-sm" width="100%">
    <thead>
        <tr>
            <th colspan="2" class="bg-primary text-light"><center>Pendapatan Bersih Oprasional</center></th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2" class="bg-info">Pendapatan</td>
      </tr>
      @php
          $laba_bersih = 0;
      @endphp
      @foreach ($jurnal as $d)
        @if ($d->jenis_akun_id == 2)
            @php
            $laba_bersih += $d->ttl_kredit;
            @endphp
            <tr>
            <td width="80%" >{{ $d->nm_akun }}</td>
            <td width="20%"><p class="text-right">
            {{ number_format($d->ttl_kredit,0) }}
            </p></td>
            </tr>
        @endif
      @endforeach
    </tbody>
    <tbody>
        <tr>
          <td colspan="2" class="bg-info">Biaya pokok penjualan</td>
        </tr>
        @foreach ($jurnal as $d)
        @if ($d->jenis_akun_id == 4)
        @php
            $laba_bersih -= $d->ttl_kredit;
        @endphp
        <tr>
          <td width="80%" >{{ $d->nm_akun }}</td>
          <td width="20%"><p class="text-right">{{ number_format($d->ttl_kredit,0) }}</p></td>
        </tr>
        @endif
        @endforeach
        
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="bg-info">Kerugian</td>
        </tr>
  
        @foreach ($rusak as $d)
        @if ($d->jenis_akun_id == 8)
        @php
            $laba_bersih -= $d->ttl_debit;
        @endphp
        <tr>
          <td width="80%" >{{ $d->nm_akun }}</td>
          <td width="20%"><p class="text-right">{{ number_format($d->ttl_debit,0) }}</p></td>
        </tr>
        @endif
        @endforeach
    
        
      </tbody>
      <tbody>
        <tr>
          <td class="bg-info">Biaya oprasional</td>
          <td class="bg-info"><a class="btn btn-sm btn-success float-right btn_biaya" href="#modal_biaya" data-toggle="modal"><i class="fas fa-plus"></i></a></td>
        </tr>
        @foreach ($jurnal as $d)
        @if ($d->jenis_akun_id == 5 || $d->jenis_akun_id == 3)
        @php
            $laba_bersih -= $d->ttl_debit;
        @endphp
        <tr>
          <td width="80%" >{{ $d->nm_akun }}</td>
          <td width="20%"><p class="text-right">{{ number_format($d->ttl_debit,0) }}</p></td>
        </tr>
        @endif
        @endforeach
      </tbody>
      <tfoot class="bg-secondary">
        <tr>
          <td><b>Laba Bersih</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($laba_bersih,0) }}</b></p></td>
        </tr>
      </tfoot>
</table>