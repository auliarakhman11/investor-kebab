@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Refund Penjualan</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
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
                @endif --}}
                  <div class="card-header">
                      {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#add-product">
                          <i class="fas fa-plus-circle"></i> 
                          Tambah Outlet
                        </button> --}}
                        <h5 class="float-left">Banyak refund {{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }}</h5>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#view">
                          <i class="fas fa-eye"></i> 
                          View
                        </button>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table table-sm" id="table">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Outlet</th>
                                      <th>Jumlah Refund</th>
                                      <th>Jumlah Produk</th>
                                      <th>Total</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($banyak_refund as $br)
                                  <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $br->outlet }}</td>
                                    <td>{{ $br->banyak }}</td>
                                    <td>{{ $br->jml_produk }}</td>
                                    <td>{{ number_format($br->total,0) }}</td>
                                  </tr>
                                @endforeach
                                  
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

                <div class="card">
                  {{-- @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif --}}
                    <div class="card-header">
                        {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#add-product">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Outlet
                          </button> --}}
                          <h5>List permintaan refund</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>No Invoice</th>
                                        <th>Costumer</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Order</th>
                                        <th>Outlet</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($refund as $r)
                                  <?php if($r->void != 1){continue;} ?>
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ date("d M Y", strtotime($r->tgl)) }}</td>
                                      <td>{{ $r->no_invoice }}</td>
                                      <td>{{ $r->nm_costumer }}</td>
                                      <td>{{ $r->total }}</td>
                                      <td>{{ $r->ket_void }}</td>
                                      <td>{{ $r->delivery->delivery }}</td>
                                      <td>{{ $r->cabang->nama }}</td>
                                      <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#detail{{ $r->id }}">
                                        <i class="fas fa-search"></i> 
                                      </button></td>
                                    </tr>
                                  @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                  {{-- @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif --}}
                    <div class="card-header">
                        {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#add-product">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Outlet
                          </button> --}}
                          <h5>List refund</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>No Invoice</th>
                                        <th>Costumer</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Order</th>
                                        <th>Outlet</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($refund as $r)
                                  <?php if($r->void != 2){continue;} ?>
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ date("d M Y", strtotime($r->tgl)) }}</td>
                                      <td>{{ $r->no_invoice }}</td>
                                      <td>{{ $r->nm_costumer }}</td>
                                      <td>{{ $r->total }}</td>
                                      <td>{{ $r->ket_void }}</td>
                                      <td>{{ $r->delivery->delivery }}</td>
                                      <td>{{ $r->cabang->nama }}</td>
                                      <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#detail-refund{{ $r->id }}">
                                        <i class="fas fa-search"></i> 
                                      </button></td>
                                    </tr>
                                  @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
  @foreach ($refund as $r)
  <?php if($r->void !=1){continue;} ?>
  <form action="{{ route('refundInvoice') }}" method="post" class="form_refund">
    @method('patch')
    @csrf
<div class="modal fade" id="detail{{ $r->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="no_invoice" value="{{ $r->no_invoice }}">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($r->getPenjualan as $p)
                <tr>
                  <th>{{ $p->produk->nm_produk }}</th>
                  <th>{{ $p->qty }}</th>
                  <th>{{ $p->harga }}</th>
                  <th>{{ $p->harga * $p->qty }}</th>
                </tr>
                @endforeach                
              </tbody>
              <tfoot class="bg-light">
                <tr>
                  <td colspan="2">Penjual</td>
                  <td colspan="2">
                    @if ($r->getPenjualanKaryawan)
                      @foreach ($r->getPenjualanKaryawan as $k)
                          {{ $k->karyawan->nama }}
                      @endforeach
                    @endif                    
                  </td>
                </tr>
              </tfoot>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  name="aksi" value="tolak" class="btn btn-primary btn_refund">Tolak</button>
          <button type="submit"  name="aksi" value="izinkan" class="btn btn-primary btn_refund">Izinkan</button>
        </div>
      </div>
    </div>
  </div>
</form>
  @endforeach

  @foreach ($refund as $r)
  <?php if($r->void != 2){continue;} ?>
  <div class="modal fade" id="detail-refund{{ $r->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Refund</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($r->getPenjualan as $p)
                <tr>
                  <th>{{ $p->produk->nm_produk }}</th>
                  <th>{{ $p->qty }}</th>
                  <th>{{ $p->harga }}</th>
                  <th>{{ $p->harga * $p->qty }}</th>
                </tr>
                @endforeach                
              </tbody>
              <tfoot class="bg-light">
                <tr>
                  <td colspan="2">Penjual</td>
                  <td colspan="2">
                    @if ($r->getPenjualanKaryawan)
                      @foreach ($r->getPenjualanKaryawan as $k)
                          {{ $k->karyawan ? $k->karyawan->nama : '' }}
                      @endforeach
                    @endif                    
                  </td>
                </tr>
              </tfoot>
            </table>
        </div>
        
      </div>
    </div>
  </div>
  @endforeach

  <form action="" method="get">
    <div class="modal fade" id="view"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-6">
                    <label for="">
                        Dari
                    </label>
                    <input type="date" name="tgl1" value="{{ $tgl1 }}" class="form-control" required>
                </div>
    
                <div class="col-6">
                  <label for="">
                      Sampai
                  </label>
                  <input type="date" name="tgl2" value="{{ $tgl2 }}" class="form-control" required>
              </div>
    
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            <button type="submit"  class="btn btn-primary">View</button>
          </div>
        </div>
      </div>
    </div>
    </form>

  


@section('script')
<script>
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

    $(document).on('submit', '.form_refund', function(){

      if (confirm('Are you sure?')) {
      
        $('.btn_refund').attr('disabled',true);
      }
    });
            
    
    
    
  });
</script>
@endsection
@endsection  
  
