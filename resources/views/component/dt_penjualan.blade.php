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
          <div class="card-header">
              {{-- <div class="row">
                  <div class="col-12 col-md-6"></div>
                  <div class="col-12 col-md-6">
                      <div class="row">
                          <div class="col-6">
                            <select id="kota_id" class="form-control">
                              @foreach ($kota as $cb)
                                  <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-6">
                            <select id="bulan_tahun" class="form-control">
                              @foreach ($bulan as $bln)
                                  <option value="{{ $bln->year }}-{{ sprintf("%02d", $bln->month)  }}">{{ date("M Y", strtotime($bln->year.'-'.$bln->month.'-01')) }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                  </div>
              </div> --}}
          </div>
          <div class="card-body">
              
              <table class="table table-sm" width="100%">
                  <thead>
                      <tr>
                          <th colspan="2" class="bg-primary text-light"><center>Laporan Penjualan</center></th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($penjualan as $d)
                    <tr>
                      <td width="80%" >{{ $d->pembayaran }}</td>
                      <td width="20%"><p class="text-right">{{ number_format($d->total,0) }}</p></td>
                    </tr>
                    @endforeach
                  </tbody>
              </table>

          </div>
      </div>
  </div>
</div>