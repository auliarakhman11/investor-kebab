<div class="table-responsive scroll">
    <table class="table" width="100%">
        <thead>
            <tr>
                <th >Antrian</th>
                <th >Jenis Pembayaran</th>
                <th >Jumlah Transaksi</th>
                <th >Produk</th>
                <th >Penjual</th>
                <th >Total</th>
                <th>Watu</th>
                <th>refund</th>
            </tr>
        </thead>
        <tbody>
  
            @foreach ($dt_invoice as $p)
  
                <tr>
                    <td>{{ $p->urutan }}</td>
                    <td>{{ $p->pembayaran->pembayaran }}</td>
                    <td>{{ $p->delivery->delivery }}</td>
                    <td>
                      @if ($p->getPenjualan)
                      @foreach ($p->getPenjualan as $d)
                          {{ $d->produk->nm_produk }} X {{ $d->qty }} <br>
                      @endforeach
                      @endif
                      
                    </td>
                    <td>
                      @if ($p->getPenjualanKaryawan)
                      @foreach ($p->getPenjualanKaryawan as $d)
                      @if ($d->karyawan)
                      {{ $d->karyawan->nama }} <br>
                      @endif
                          
                      @endforeach
                      @endif
                    </td>
                    <td>{{ number_format($p->total,0) }}</td>
                    <td><strong>{{ date("H:i", strtotime($p->created_at)) }}</strong></td>
                    <td>
                        <button type="button" class="btn btn-xs btn-danger refund" no_invoice = "{{ $p->no_invoice }}">
                            Refund
                          </button>
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>