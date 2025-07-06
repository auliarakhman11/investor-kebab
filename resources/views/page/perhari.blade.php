@extends('template.master')
@section('chart')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 float-left">Laporan Penjualan Perhari {{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }} <br> {{ $dt_cabang ? 'Outlet '. $dt_cabang->nama : ''}}</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#view">
                <i class="fas fa-eye"></i> 
                View
              </button>
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
                <canvas id="perhari" width="400" height="180" class="bg-light"></canvas>
            </div>
            <br>
            
        </div>
      </div><!--/. container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">

                    <div class="col-4">
                      <h3 class="float-left">Penjualan Perhari</h3> <br>
                      <p class="float-left">{{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }}</p> <br>
                      <p class="float-left">{{ $dt_cabang ? 'Outlet '.$dt_cabang->nama : '' }}</p>
                    </div>

                    <div class="col-8">
                        <div class="row">
                            @php
                                $jml_invoice = 0;
                                $jml_penjualan = 0;
                                $total_penjualan = 0;
                                $jml_komisi = 0;
                            @endphp
                            @foreach ($perhari as $d)
                                @php
                                    $jml_invoice += $d['jml_invoice'];
                                    $jml_penjualan += $d['jml_penjualan'];
                                    $total_penjualan += $d['total_penjualan'];
                                    $jml_komisi += $d['jml_komisi'];
                                @endphp
                            @endforeach

                            <div class="col-6 ">
                            <div class="info-box mb-3 ">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-invoice"></i></span>
                
                                <div class="info-box-content">
                                <span class="info-box-text">Transaksi</span>
                                <span class="info-box-number">{{ number_format($jml_invoice,0) }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                            </div>

                            <div class="col-6 ">
                                <div class="info-box mb-3 ">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    
                                <div class="info-box-content">
                                    <span class="info-box-text">Produk Terjual</span>
                                    <span class="info-box-number">{{ number_format($jml_penjualan,0) }}</span>
                                </div>
                                <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-6 ">
                                <div class="info-box mb-3 ">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Penjualan</span>
                                    <span class="info-box-number">Rp. {{ number_format($total_penjualan,2) }}</span>
                                </div>
                                <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-6 ">
                                <div class="info-box mb-3 ">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-comments-dollar"></i></span>
                    
                                <div class="info-box-content">
                                    <span class="info-box-text">Komisi</span>
                                    <span class="info-box-number">Rp. {{ number_format($jml_komisi,2) }}</span>
                                </div>
                                <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>
                    </div>

                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    @php
                        $i=1;
                    @endphp
                    <table class="table table-striped" id="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Tanggal</th>
                          <th>Kota</th>
                          <th>Transaksi</th>
                          <th>Terjual</th>
                          <th>Total Penjualan</th>
                          <th>Komisi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($perhari as $p)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $p['nm_kota'] }}</td>
                          <td>{{ date("d M Y", strtotime($p['tgl'])) }}</td>
                          <td>{{ number_format($p['jml_invoice'],0) }}</td>
                          <td>{{ number_format($p['jml_penjualan'],0) }}</td>
                          <td>Rp. {{ number_format($p['total_penjualan'],2) }}</td>
                          <td>Rp. {{ number_format($p['jml_komisi'],2) }}</td>
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

              <div class="col-12">
                <label for="">Outlet</label>
                <select name="outlet" class="form-control select2bs4">
                  <option value="">-Pilih Outlet-</option>
                  @foreach ($cabang as $c)
                  <option value="{{ $c->id }}">{{ $c->nama }}</option>
                  @endforeach                  
                </select>
              </div>
    
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="submit" name="tombol" value="batal" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan pesanan?')">Batalkan</button> --}}
            <button type="submit"  class="btn btn-primary">View</button>
          </div>
        </div>
      </div>
    </div>
    </form>






@section('script')
<script>
    var penjualan = JSON.parse(`<?php echo $chart_penjualan; ?>`);
    var periode = JSON.parse(`<?php echo $chart_periode; ?>`);
    var invoice = JSON.parse(`<?php echo $chart_invoice; ?>`);
    
    const ctx = document.getElementById('perhari').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: periode,
        datasets: [{
            label: 'Transaksi',
            data: invoice,
            backgroundColor: '#FBD22C',
            borderColor: '#FBD22C',
            borderWidth: 1
        },
        {
            label: 'Penjualan',
            data: penjualan,
            backgroundColor: '#00B7B6',
            borderColor: '#00B7B6',
            borderWidth: 1
        },
        // {
        //     label: 'Komisi',
        //     data: komisi,
        //     backgroundColor: '#C871CC',
        //     borderColor: '#C871CC',
        //     borderWidth: 1
        // },
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
  $(document).ready(function() {

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
    
  });
</script>
@endsection
@endsection  
  
