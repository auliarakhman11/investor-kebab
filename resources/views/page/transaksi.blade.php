@extends('template.master')
{{-- @section('chart')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection --}}
@section('content')

<style>
  .scroll {
    overflow-x: auto;
    height:600px;
    overflow-y: scroll;
    }
</style>

      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h5 class="m-0 float-left">Laporan Transaksi {{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }} <br> {{ $dt_cabang ? 'Outlet '. $dt_cabang->nama : ''}}</h5> --}}
          </div><!-- /.col -->
          <div class="col-sm-6">
            {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#view">
                <i class="fas fa-eye"></i> 
                View
              </button> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    {{-- <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <canvas id="perhari" width="400" height="180" class="bg-light"></canvas>
            </div>
            <br>
            
        </div>
      </div>
    </section> --}}

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

              <ul class="nav nav-tabs" id="myTab" role="tablist">
                {{-- <li class="nav-item">
                  <a class="nav-link active" id="transaksi-tab" data-toggle="tab" href="#transaksi" role="tab" aria-controls="transaksi" aria-selected="true">Transaksi</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="detail-transaksi-tab" data-toggle="tab" href="#detail-transaksi" role="tab" aria-controls="detail-transaksi" aria-selected="false">Detail Transaksi</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="buka-toko-tab" data-toggle="tab" href="#buka-toko" role="tab" aria-controls="buka-toko" aria-selected="false">Buka toko</a>
                </li> --}}


                <li class="nav-item">
                  <a class="nav-link active" id="buka-toko-detail-tab" data-toggle="tab" href="#buka-toko-detail" role="tab" aria-controls="buka-toko-detail" aria-selected="true">Detail Buka toko</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="penjualan-barang-tab" data-toggle="tab" href="#penjualan-barang" role="tab" aria-controls="penjualan-barang" aria-selected="false">Penjualan Bahan</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="print1-tab" data-toggle="tab" href="#print1" role="tab" aria-controls="print1" aria-selected="false">Print > 1</a>
                </li>

              </ul>
              <div class="tab-content" id="myTabContent">

                {{-- <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">

                  <div class="card">
                    <div class="card-header">
                      <div class="row">
    
                        <div class="col-4">
                          <h3 class="float-left">Laporan Transaksi</h3> <br>
                          <p class="float-left">{{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }}</p> <br>
                          <p class="float-left">{{ $dt_cabang ? 'Outlet '.$dt_cabang->nama : '' }}</p>
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
                              <th>Outlet</th>
                              <th>Jenis Order</th>
                              <th>Jenis Pembayaran</th>
                              <th>Jumlah Transaksi</th>
                              <th>Produk Terjual</th>
                              <th>Total Penjualan</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($transaksi as $p)
                            <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ date("d M Y", strtotime($p->tgl)) }}</td>
                              <td>{{ $p->cabang }}</td>
                              <td>{{ $p->delivery }}</td>
                              <td>{{ $p->pembayaran }}</td>
                              <td>{{ number_format($p->jml_invoice,0) }}</td>
                              <td>{{ number_format($p->produk_terjual,0) }}</td>
                              <td>Rp. {{ number_format($p->ttl_penjualan,2) }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
    
                  </div>

                </div> --}}

                {{-- detail transaksi --}}

                {{-- <div class="tab-pane fade" id="detail-transaksi" role="tabpanel" aria-labelledby="detail-transaksi-tab">

                  <div class="card">
                    <div class="card-header">
                      <div class="row">
    
                        <div class="col-4">
                          <h3 class="float-left">Laporan Detail Transaksi</h3> <br>
                          <p class="float-left">{{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }}</p> <br>
                          <p class="float-left">{{ $dt_cabang ? 'Outlet '.$dt_cabang->nama : '' }}</p>
                        </div>
    
                      </div>
                    </div>
    
                    <div class="card-body">
                      <div class="table-responsive">
                        @php
                            $i=1;
                        @endphp
                        <table class="table table-striped" id="table3">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Tanggal</th>
                              <th>Cabang</th>
                              <th>Jenis Order</th>
                              <th>Jenis Pembayaran</th>
                              <th>Jumlah Produk</th>
                              <th>Total</th>
                              <th>Waktu</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($detail_transaksi as $dp)
                            <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ date("d M Y", strtotime($dp->tgl)) }}</td>
                              <td>{{ $dp->nama }}</td>
                              <td>{{ $dp->delivery }}</td>
                              <td>{{ $dp->pembayaran }}</td>
                              <td>{{ $dp->jml_produk }}</td>
                              <td>{{ $dp->ttl_penjualan }}</td>
                              <td>{{ date("H:i:s", strtotime($dp->created_at)) }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
    
                  </div>

                </div> --}}

                {{-- buka toko --}}

                {{-- <div class="tab-pane fade" id="buka-toko" role="tabpanel" aria-labelledby="buka-toko-tab">

                  <div class="card">
                    <div class="card-header">
                      <div class="row">
    
                        <div class="col-4">
                          <h3 class="float-left">Laporan Buka Toko</h3> <br>
                          <p class="float-left">{{ date("d M Y", strtotime($tgl1)) }} - {{ date("d M Y", strtotime($tgl2)) }}</p> <br>
                          <p class="float-left">{{ $dt_cabang ? 'Outlet '.$dt_cabang->nama : '' }}</p>
                        </div>
    
                      </div>
                    </div>
    
                    <div class="card-body">
                      <div class="table-responsive">
                        @php
                            $i=1;
                        @endphp
                        <table class="table table-striped" id="table2">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Tanggal</th>
                              <th>Cabang</th>
                              <th>Karyawan</th>
                              <th>Buka</th>
                              <th>Tutup</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($buka_toko as $bt)
                            <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ date("d M Y", strtotime($bt->tgl)) }}</td>
                              <td>{{ $bt->cabang->nama }}</td>
                              <td>{{ $bt->nm_karyawan }}</td>
                              <td>{{ date("H:i:s", strtotime($bt->buka)) }}</td>
                              <td>{{ $bt->tutup ? date("H:i:s", strtotime($bt->tutup)) : '-' }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
    
                  </div>

                </div> --}}

                {{-- Detail buka toko --}}

                <div class="tab-pane fade show active" id="buka-toko-detail" role="tabpanel" aria-labelledby="buka-toko-detail-tab">

                  <div class="card">
                    <div class="card-header">

                      <div class="row">
                        <div class="col-8">
                          <h3 class="float-left">Detail Buka Toko</h3>
                        </div>
                        <div class="col-2">
                          <select id="akses_kota3" class="form-control">
                            @foreach ($akses_kota as $ak)
                                <option value="{{ $ak->kota_id }}">{{ $ak->nm_kota }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-2">
                          <select id="tanggal3" class="form-control">
                            @foreach ($tanggal as $t)
                                <option value="{{ $t->tgl }}">{{ date("d M Y", strtotime($t->tgl)) }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                          
                          {{-- <a href="{{ route('excelLaporanPenjualan') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-file-excel"></i> Laporan</a>     --}}
                      
                    </div>
    
                    <div class="card-body scroll" id="table_buka_toko">
                      
                    </div>
    
                  </div>

                </div>


                <div class="tab-pane fade" id="penjualan-barang" role="tabpanel" aria-labelledby="penjualan-barang-tab">

                  <div class="card">
                    <div class="card-header">
                      
                          
                          <div class="row">
                            <div class="col-8">
                              <h3 class="float-left">Detail Penjualan Barang</h3>
                            </div>
                            <div class="col-2">
                              <select id="akses_kota" class="form-control">
                                @foreach ($akses_kota as $ak)
                                    <option value="{{ $ak->kota_id }}">{{ $ak->nm_kota }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-2">
                              <select id="tanggal" class="form-control">
                                @foreach ($tanggal as $t)
                                    <option value="{{ $t->tgl }}">{{ date("d M Y", strtotime($t->tgl)) }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                      
                    </div>
    
                    <div class="card-body" id="table-detail-penjualan"></div>
    
                  </div>

                </div>

                <div class="tab-pane fade" id="print1" role="tabpanel" aria-labelledby="print1-tab">

                  <div class="card">
                    <div class="card-header">
                      
                          
                          <div class="row">
                            <div class="col-8">
                              <h3 class="float-left">Print Lebih Dari 1X</h3>
                            </div>
                            <div class="col-2">
                              <select id="akses_kota2" class="form-control">
                                @foreach ($akses_kota as $ak)
                                    <option value="{{ $ak->kota_id }}">{{ $ak->nm_kota }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-2">
                              <select id="tanggal2" class="form-control">
                                @foreach ($tanggal as $t)
                                    <option value="{{ $t->tgl }}">{{ date("d M Y", strtotime($t->tgl)) }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                      
                    </div>
    
                    <div class="card-body scroll" id="table_print">

                      

                    </div>
    
                  </div>

                </div>

                {{-- end detail buka toko --}}

              </div>

              
            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
  
    <div class="modal fade" id="detail-buka"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form-detail-buka">
              
          </div>
          
        </div>
      </div>
    </div>

    <div class="modal fade" id="detail-bawaan"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail barang bawaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" id="id_buka">
          <div class="modal-body" id="form-detail-bawaan">
              
          </div>
          
        </div>
      </div>
    </div>

    <div class="modal fade" id="refund-invoice"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Refund Invoice</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <input type="hidden" id="id_buka_invoice">
          </div>
          <div class="modal-body" id="table-refund-invoice">
              
          </div>
          
        </div>
      </div>
    </div>





@section('script')

<script>

$(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


  $(document).ready(function() {

    var data_tgl_buka = $('#tanggal3').val();
    var akses_kota = $('#akses_kota3').val();
    getDataBuka(data_tgl_buka,akses_kota);

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

    function getDataBuka(tanggal3,akses_kota3){
      $('#table_buka_toko').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getDataBuka') }}",
                method:"GET",
                data:{tanggal3:tanggal3, akses_kota3:akses_kota3},
                success:function(data){
                  $('#table_buka_toko').html(data);
                  
                }

              });
    }

    

    function getPenjualanBarang(tanggal, akses_kota){
      $('#table-detail-penjualan').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getDetailPenjualan') }}",
                method:"GET",
                data:{tanggal:tanggal, akses_kota:akses_kota},
                success:function(data){
                  $('#table-detail-penjualan').html(data);
                  
                }

              });
    }

    function getPrint(tanggal2,akses_kota2){
      $('#table_print').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getPrint') }}",
                method:"GET",
                data:{tanggal2:tanggal2, akses_kota2:akses_kota2},
                success:function(data){
                  $('#table_print').html(data);
                  
                }

              });
    }

    function getRefundInvoice(kode){
      $('#table-refund-invoice').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      id_buka_invoice
      $.ajax({
                url:"{{ route('getRefundInvoice') }}",
                method:"GET",
                data:{kode:kode},
                success:function(data){
                  $('#table-refund-invoice').html(data);

                  $('#id_buka_invoice').val(kode);
                  
                }

              });
    }

    $(document).on('click', '.refund-invoice', function() {
      var kode = $(this).attr('kode');

      getRefundInvoice(kode);

      });

      $(document).on('click', '.refund', function() {
      

      if (confirm('Apakah anda yakin ingin merefund?')) {
        $('#table-refund-invoice').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
        var no_invoice = $(this).attr('no_invoice');
        $.ajax({
                url:"{{ route('refundDataInvoice') }}",
                method:"POST",
                data:{no_invoice:no_invoice},
                success:function(data){
                var kode = $('#id_buka_invoice').val();
                getRefundInvoice(kode);
                Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Invoice berhasil direfund'
                    });  
                }

              });
      }

      });

      $(document).on('click', '.buka-toko', function() {
      if (confirm('Apakah anda yakin ingin membuka toko ?')) {
        var kode = $(this).attr('kode');
        $.ajax({
                url:"{{ route('bukaToko') }}",
                method:"POST",
                data:{kode:kode},
                success:function(data){
                Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Toko Berhsil Dibuka Kembali'
                    });

                    var tanggal3 = $('#tanggal3').val();
                    var akses_kota3 = $('#akses_kota3').val();
                    getDataBuka(tanggal3,akses_kota3);

                }

              });
      }

      });

    $(document).on('click', '#buka-toko-detail-tab', function() {
      var tanggal3 = $('#tanggal3').val();
      var akses_kota3 = $('#akses_kota3').val();

      getDataBuka(tanggal3,akses_kota3);

      });

      $(document).on('change', '#tanggal3', function() {
          var tanggal3 = $(this).val();
          var akses_kota3 = $('#akses_kota3').val();
          getDataBuka(tanggal3, akses_kota3);
          
      });

      $(document).on('change', '#akses_kota3', function() {
          var akses_kota3 = $(this).val();
          var tanggal3 = $('#tanggal3').val();
          getDataBuka(tanggal3, akses_kota3);
          
      });

    $(document).on('click', '#print1-tab', function() {
      var tanggal2 = $('#tanggal2').val();
      var akses_kota2 = $('#akses_kota2').val();

      getPrint(tanggal2,akses_kota2);

      });

      $(document).on('change', '#tanggal2', function() {
          var tanggal2 = $(this).val();
          var akses_kota2 = $('#akses_kota2').val();
          getPrint(tanggal2, akses_kota2);
          
      });

      $(document).on('change', '#akses_kota2', function() {
          var akses_kota2 = $(this).val();
          var tanggal2 = $('#tanggal2').val();
          getPrint(tanggal2, akses_kota2);
          
      });

    $(document).on('click', '#penjualan-barang-tab', function() {
      var tanggal = $('#tanggal').val();
      var akses_kota = $('#akses_kota').val();

                getPenjualanBarang(tanggal,akses_kota);

            });

      $(document).on('change', '#tanggal', function() {
          var tanggal = $(this).val();
          var akses_kota = $('#akses_kota').val();
          getPenjualanBarang(tanggal,akses_kota);
          
      });

      $(document).on('change', '#akses_kota', function() {
          var akses_kota = $(this).val();
          var tanggal = $('#tanggal').val();
          getPenjualanBarang(tanggal,akses_kota);
          
      });


      function detailBuka(id_buka){
        $.ajax({
                url:"{{ route('getBuka') }}",
                method:"GET",
                data:{id_buka:id_buka},
                success:function(data){
                  $('#form-detail-buka').html(data);

                  $('.select2bs4').select2({
                      theme: 'bootstrap4',
                      tags: true,
                  });
                  
                }

              });
      }

    $(document).on('click', '.detail-buka', function() {
      $('#form-detail-buka').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      var id_buka = $(this).attr("id_buka");

      // $('#id_buka_kebutuhan').val(id_buka);

      detailBuka(id_buka)

            });

            function getBawaan(id_buka){
              $.ajax({
                        url:"{{ route('getBawaan') }}",
                        method:"GET",
                        data:{id_buka:id_buka},
                        success:function(data){
                          $('#form-detail-bawaan').html(data);
                          $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
                        }

                      });
            }

            $(document).on('click', '.detail-bawaan', function() {
              var id_buka = $(this).attr("id_buka");
              $('#id_buka').val(id_buka);                        

                getBawaan(id_buka);

                    });

    var count_bahan = 1;
    $(document).on('click', '#btn-tambah-bawan', function() {
      count_bahan = count_bahan + 1;
      var html_code = '<div class="row" id="row'+count_bahan+'">';

      html_code += '<div class="col-8"><div class="form-group"><select name="id_bahan[]"  class="form-control select2bs4" required><option value="">-Pilih Bahan-</option><?php foreach ($bahan as $b) : ?><option value="<?= $b->id; ?>"><?= $b->bahan; ?></option><?php endforeach; ?> </select></div></div>';

      html_code += '<div class="col-3"><div class="form-group"><input type="number" name="takaran[]" class="form-control" required></div></div>';

      html_code += '<div class="col-1"><button type="button" data-row="row' + count_bahan + '" class="btn btn-danger btn-sm remove_bahan">-</button></div>';

      html_code += "</div>";

      $('#form-tambah-bawaan').append(html_code);
      $('.select2bs4').select2({
                      theme: 'bootstrap4',
                      tags: true,
                  });
    });

    $(document).on('click', '.remove_bahan', function() {
      var delete_row = $(this).data("row");
      $('#' + delete_row).remove();
    });

    // kebutuhan
    var count_kebutuhan = 1;
    $(document).on('click', '#btn-tambah-kebutuhan', function() {
      count_kebutuhan = count_kebutuhan + 1;
      var html_code = '<div class="row" id="row_kebutuhan'+count_kebutuhan+'">';

      html_code += '<div class="col-8"><div class="form-group"><select name="barang_id[]"  class="form-control select2bs4" required><option value="">-Pilih Bahan-</option><?php foreach ($barang_kebutuhan as $b) : ?><option value="<?= $b->id; ?>"><?= $b->nm_barang; ?></option><?php endforeach; ?> </select></div></div>';

      html_code += '<div class="col-3"><div class="form-group"><input type="number" name="qty_kebutuhan[]" class="form-control" required></div></div>';

      html_code += '<div class="col-1"><button type="button" data-row="row_kebutuhan' + count_kebutuhan + '" class="btn btn-danger btn-sm remove_kebutuhan">-</button></div>';

      html_code += "</div>";

      $('#form-tambah-kebutuhan').append(html_code);
      $('.select2bs4').select2({
                      theme: 'bootstrap4',
                      tags: true,
                  });
    });

    $(document).on('click', '.remove_kebutuhan', function() {
      var delete_row = $(this).data("row");
      $('#' + delete_row).remove();
    });

    $(document).on('submit', '#form-edit-kebutuhan', function(event) {
        event.preventDefault();
        var id_buka_kebutuhan = $('#id_buka_kebutuhan').val();
            $.ajax({
                url:"{{ route('editKebutuhan') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                  // console.log(data);

                  detailBuka(id_buka_kebutuhan);
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Data berhasil diedit'
                    });  
                },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    
                                }
            });

        });

    $(document).on('click', '.delete-kebutuhan', function() {
      if (confirm("Apakah anda yakin?")) {

        var id_buka_kebutuhan = $('#id_buka_kebutuhan').val();

        var id = $(this).attr('kebutuhan_id');

        $.ajax({
                  url:"{{ route('dropKebutuhan') }}",
                  method:"GET",
                  data:{id:id},
                  success:function(data){
                    detailBuka(id_buka_kebutuhan);
                      Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Data berhasil dihapaus'
                      });                    
                  }

                });
      }
    return false;
      
    });
    //end kebutuhan

    $(document).on('click', '.delete-bahan', function() {
      if (confirm("Apakah anda yakin?")) {
        var id = $(this).attr("stok_id");
        var id_buka = $('#id_buka').val();
        $.ajax({
                  url:"{{ route('dropBahan') }}",
                  method:"GET",
                  data:{id:id},
                  success:function(data){
                    getBawaan(id_buka);
                      Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Data berhasil dihapaus'
                      });                    
                  }

                });
      }
    return false;
      
    });

    $(document).on('submit', '#form-edit-bawaan', function(event) {
        event.preventDefault();
        var id_buka = $('#id_buka').val();
            $.ajax({
                url:"{{ route('editBawaan') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                  getBawaan(id_buka);
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Data berhasil diedit'
                    });  
                },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    
                                }
            });

        });
    
  });
</script>
@endsection
@endsection  
  
