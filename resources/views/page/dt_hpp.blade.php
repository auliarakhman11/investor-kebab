@extends('template.master')
@section('content')

      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        {{-- <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Products</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row --> --}}
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
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
                        <a href="{{ route('laporanJurnal') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th colspan="3" class="bg-primary text-light"><center>Harga Pokok Penjualan</center></th>
                                </tr>
                                <tr>
                                    <th class="text-center">Barang</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($biaya_bahan as $d)
                              <tr>
                                <td width="40%" >{{ $d->nama_barang }}</td>
                                <td width="30%"><p class="text-right">{{ number_format($d->qty,0) }}</p></td>
                                <td width="30%"><p class="text-right">{{ number_format($d->jumlah,0) }}</p></td>
                              </tr>
                              @endforeach
                              @foreach ($biaya_varian as $d)
                              <tr>
                                <td width="40%" >{{ $d->nama_barang }}</td>
                                <td width="30%"><p class="text-right">{{ number_format($d->qty,0) }}</p></td>
                                <td width="30%"><p class="text-right">{{ number_format($d->jumlah,0) }}</p></td>
                              </tr>
                              @endforeach
                              @foreach ($biaya_kebutuhan as $d)
                              <tr>
                                <td width="40%" >{{ $d->nama_barang }}</td>
                                <td width="30%"><p class="text-right">{{ number_format($d->qty,0) }}</p></td>
                                <td width="30%"><p class="text-right">{{ number_format($d->jumlah,0) }}</p></td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@section('script')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>

<script>

$(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

  $(document).ready(function() {

    <?php if(session('success')): ?>
    Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              icon: 'success',
              title: '<?= session('success'); ?>'
            });            
    <?php endif; ?>

    <?php if(session('error')): ?>
    Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              icon: 'error',
              title: '<?= session('error'); ?>'
            });            
    <?php endif; ?>
       
    
  });
</script>
@endsection
@endsection  
  
