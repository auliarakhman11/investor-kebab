<div class="row justify-content-center">
  <div class="col-12">
      <div class="card">
        {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif --}}
          
          <div class="card-body">
              
              <table class="table table-sm table-bordered" width="100%">
                  <thead>
                      <tr>
                          <th colspan="3" class="bg-primary text-light"><center>Harga Pokok Penjualan Bahan</center></th>
                      </tr>
                      <tr>
                          <th class="text-center">Bahan</th>
                          <th class="text-center">Qty</th>
                          <th class="text-center">Total</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($stok as $d)
                    <tr>
                      <td width="40%" >{{ $d->bahan }}</td>
                      <td width="30%"><p class="text-right">{{ number_format($d->ttl_kredit - $d->ttl_debit,0) }}</p></td>
                      <td width="30%"><p class="text-right">{{ number_format($d->harga_keluar - $d->harga_refund,0) }}</p></td>
                    </tr>
                    @endforeach
                  </tbody>
              </table>

          </div>
      </div>
  </div>
</div>