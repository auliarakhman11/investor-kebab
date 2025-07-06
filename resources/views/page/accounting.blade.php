@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->

      <style>
        /* .scroll_horizontal {
          overflow-x: auto;
          white-space: nowrap;
        } */
      
        div.scroll_horizontal {
            overflow-y: scroll;
            overflow-x: auto;
            white-space: nowrap;
            height:400px;
        }
      
        div.scroll_horizontal table {
            display: inline-block;
            
        }
    
        div.scroll_horizontal_minuman {
            overflow-y: scroll;
            overflow-x: auto;
            white-space: nowrap;
        }
      
        div.scroll_horizontal_minuman table {
            display: inline-block;
            
        }
    
        /* .scroll_table {
        overflow-x: auto;
        height:600px;
        overflow-y: scroll;
        }
    
        div.scroll_horizontal table {
            display: inline-block;
            
        } */
    
        .th-atas {
          position: -webkit-sticky; /* Safari */
          position: sticky;
          top:0;
        }
    
        .th-middle {
          position: -webkit-sticky; /* Safari */
          position: sticky;
          top: 20px;
        }
    
    
      </style>
      
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Manager Store</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="row">
              <div class="col-8">
                <select id="cabang_id" class="form-control">
                  @foreach ($cabang as $cb)
                      <option value="{{ $cb->id }}">{{ $cb->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                <select id="bulan_tahun" class="form-control">
                  @foreach ($bulan as $bln)
                      <option value="{{ $bln->year }}-{{ sprintf("%02d", $bln->month)  }}">{{ date("M Y", strtotime($bln->year.'-'.$bln->month.'-01')) }}</option>
                  @endforeach
                </select>
              </div>
            </div>
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
              <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link active" id="accounting-tab" data-toggle="tab" href="#accounting" role="tab" aria-controls="accounting" aria-selected="true">Accounting</a>
                </li>

              </ul>
              <div class="tab-content" id="myTabContent">

                {{-- Accounting --}}

                <div class="tab-pane fade show active" id="accounting" role="tabpanel" aria-labelledby="accounting-tab">

                  <div class="card">
    
                    <div class="card-body scroll" id="table_manager_store">

                      

                    </div>

                    <div class="card-body scroll" id="table_ms_pengeluaran">

                      

                    </div>
    
                  </div>

                </div>
                

                {{-- end Accounting --}}

              </div>
            </div>


        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <form id="form_input_pengeluaran">
<div class="modal fade" id="modal_input_pengeluaran" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pengeluaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

              <input type="hidden" name="tgl" id="tgl_input">
              <input type="hidden" name="akun_pengeluaran_id" id="akun_pengeluaran_id_input">
              <input type="hidden" name="cabang_id" id="cabang_id_input">

                <div class="col-12">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" id="harga_input" required>
                </div>


                <div class="col-12">
                  <label>Qty</label>
                  <input type="number" name="qty" class="form-control" step=".01" required>
                </div>

            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_input_pengeluaran">Input</button>
        </div>
      </div>
    </div>
  </div>
</form>


<form id="form_edit_pengeluaran">
  <div class="modal fade" id="modal_edit_pengeluaran" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pengeluaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
  
              <div class="row">
  
                <input type="hidden" name="pengeluaran_id" id="pengeluaran_id">
  
                  <div class="col-12">
                      <label>Harga</label>
                      <input type="number" name="harga" class="form-control" id="harga_edit" required>
                  </div>
  
  
                  <div class="col-12">
                    <label>Qty</label>
                    <input type="number" name="qty" class="form-control" step=".01" id="qty_edit" required>
                  </div>
  
              </div>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_edit_pengeluaran">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </form>

{{-- saldo awal --}}
  <form id="form_edit_saldo_awal">
    <div class="modal fade" id="modal_edit_saldo_awal" role="dialog" aria-labelledby="edit_saldo_awal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="edit_saldo_awal_label"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
    
                <div class="row">
    
                  <input type="hidden" name="saldo_awal_id" id="saldo_awal_id_edit">
    
                    <div class="col-12">
                      <label>Saldo Awal</label>
                      <input type="number" name="saldo_awal" class="form-control" min="1" id="saldo_awal_edit" required>
                    </div>
    
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn_edit_saldo_awal">Edit</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form id="form_input_saldo_awal">
      <div class="modal fade" id="modal_input_saldo_awal" role="dialog" aria-labelledby="input_saldo_awal_label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="input_saldo_awal_label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
      
                  <div class="row">
      
                    <input type="hidden" name="bulan_tahun" id="bulan_tahun_input">

                    <input type="hidden" name="id_barang" id="id_barang_input">

                    <input type="hidden" name="jenis_data" id="jenis_data_input">

                    <input type="hidden" name="cabang_id" id="cabang_id_input_saldo">
      
                      <div class="col-12">
                        <label>Saldo Awal</label>
                        <input type="number" name="saldo_awal" min="1" class="form-control" id="saldo_awal_input" required>
                      </div>
      
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn_input_saldo_awal">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    {{-- end saldo awal --}}

    {{-- stok Barang --}}
    <form id="form_stok_barang">
      <div class="modal fade" id="modal_stok_barang" role="dialog" aria-labelledby="stok_barang_label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="stok_barang_label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="cabang_id" id="cabang_id_stok">
                <input type="hidden" name="bahan_baku_id" id="bahan_baku_id_stok">
                <input type="hidden" name="jenis_data" id="jenis_data_stok">
                  <div id="table_stok_barang"></div>

                  <div id="tambah_table_stok_barang"></div>
                  <div class="row justify-content-end">
                    <div class="col-2">
                      <button id="tambah_input_stok_barang" class="btn btn-xs btn-primary float-right"><i class="fas fa-plus"></i></button>
                    </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn_stok_barang">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    {{-- end stok barang --}}

    {{-- stok baku --}}
    <form id="form_input_stok_baku">
      <div class="modal fade" id="modal_input_stok_baku" role="dialog" aria-labelledby="input_stok_baku_label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="input_stok_baku_label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="cabang_id" id="cabang_id_stok_baku">
                <input type="hidden" name="bahan_baku_id" id="bahan_baku_id_stok_baku">
                <input type="hidden" name="jenis_data" id="jenis_data_stok_baku">

                  <div class="form-group">
                    <label for="">Stok Baku</label>
                    <input type="number" class="form-control from-control-sm" name="stok_baku" step=".01" required>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn_input_stok_baku">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <form id="form_edit_stok_baku">
        <div class="modal fade" id="modal_edit_stok_baku" role="dialog" aria-labelledby="edit_stok_baku_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="edit_stok_baku_label"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="stok_baku_id">
                    <div id="table_edit_stok_baku"></div>
  
                    <div class="form-group">
                      <label for="">Stok Baku</label>
                      <input type="number" class="form-control from-control-sm" name="stok_baku" step=".01" id="stok_baku" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="btn_edit_stok_baku">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
    {{-- end stok baku --}}


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

    var cabang_id = $('#cabang_id').val();
    var bulan_tahun = $('#bulan_tahun').val();

    getManagerStore(cabang_id,bulan_tahun);

    // getMsPengeluaran(cabang_id,bulan_tahun);

    function getManagerStore(cabang_id,bulan_tahun){
      $('#table_manager_store').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getManagerStore') }}",
                method:"GET",
                data:{cabang_id:cabang_id, bulan_tahun:bulan_tahun},
                success:function(data){
                  $('#table_manager_store').html(data);
                  getMsPengeluaran(cabang_id,bulan_tahun);
                }

              });
    }

    function getMsPengeluaran(cabang_id,bulan_tahun){
      $('#table_ms_pengeluaran').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getMsPengeluaran') }}",
                method:"GET",
                data:{cabang_id:cabang_id, bulan_tahun:bulan_tahun},
                success:function(data){
                  $('#table_ms_pengeluaran').html(data);
                  
                }

              });
    }

    $(document).on('change', '#cabang_id', function() {
          var cabang_id = $(this).val();
          var bulan_tahun = $('#bulan_tahun').val();
          getManagerStore(cabang_id, bulan_tahun);
          // getMsPengeluaran(cabang_id,bulan_tahun);
          
      });

      $(document).on('change', '#bulan_tahun', function() {
          var cabang_id = $('#cabang_id').val();
          var bulan_tahun = $(this).val();
          getManagerStore(cabang_id, bulan_tahun);
          // getMsPengeluaran(cabang_id,bulan_tahun);
          
          
      });

      //pengeluaran
      $(document).on('click', '.btn-input-pengeluaran', function() {
          var tgl = $(this).attr('tgl');
          var akun_pengeluaran_id = $(this).attr('akun_pengeluaran_id');
          var harga = $(this).attr('harga');


          $('#tgl_input').val(tgl);
          $('#harga_input').val(harga);
          $('#akun_pengeluaran_id_input').val(akun_pengeluaran_id);
          $('#cabang_id_input').val(cabang_id);
      });


      $(document).on('submit', '#form_input_pengeluaran', function(event) {
                event.preventDefault();
                    $('#btn_input_pengeluaran').attr('disabled',true);
                    $('#btn_input_pengeluaran').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('inputPengeluaran') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_input_pengeluaran").removeAttr("disabled");
                                $('#btn_input_pengeluaran').html('Input'); //tombol simpan
                                $('#modal_input_pengeluaran').modal('hide');
                                $('#form_input_pengeluaran').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diinput'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_input_pengeluaran').html('Input');
                                $("#btn_input_pengeluaran").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_input_pengeluaran').html('Input');
                                    $("#btn_input_pengeluaran").removeAttr("disabled");
                                }
                    });

    });

    $(document).on('click', '.btn-edit-pengeluaran', function() {
          var pengeluaran_id = $(this).attr('pengeluaran_id');
          var qty = $(this).attr('qty');
          var harga = $(this).attr('harga');


          $('#pengeluaran_id').val(pengeluaran_id);
          $('#harga_edit').val(harga);
          $('#qty_edit').val(qty);
      });

      $(document).on('submit', '#form_edit_pengeluaran', function(event) {
                event.preventDefault();
                    $('#btn_edit_pengeluaran').attr('disabled',true);
                    $('#btn_edit_pengeluaran').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('editPengeluaran') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_edit_pengeluaran").removeAttr("disabled");
                                $('#btn_edit_pengeluaran').html('Edit'); //tombol simpan
                                $('#modal_edit_pengeluaran').modal('hide');
                                $('#form_edit_pengeluaran').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_edit_pengeluaran').html('Edit');
                                $("#btn_edit_pengeluaran").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_edit_pengeluaran').html('Edit');
                                    $("#btn_edit_pengeluaran").removeAttr("disabled");
                                }
                    });

    });
      //endpengeluaran

      //saldo
      $(document).on('click', '.input_saldo_awal', function() {
          var id_barang = $(this).attr('id_barang');
          var nm_item = $(this).attr('nm_item');
          var jenis_data = $(this).attr('jenis_data');

          var cabang_id = $('#cabang_id').val();
          var bulan_tahun = $('#bulan_tahun').val();

          $('#id_barang_input').val(id_barang);
          $('#jenis_data_input').val(jenis_data);
          $('#bulan_tahun_input').val(bulan_tahun);
          $('#cabang_id_input_saldo').val(cabang_id);
          $('#input_saldo_awal_label').text('Saldo Awal ' +nm_item)
      });

      $(document).on('submit', '#form_input_saldo_awal', function(event) {
                event.preventDefault();
                    $('#btn_input_saldo_awal').attr('disabled',true);
                    $('#btn_input_saldo_awal').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('inputSaldoAwal') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_input_saldo_awal").removeAttr("disabled");
                                $('#btn_input_saldo_awal').html('Edit'); //tombol simpan
                                $('#modal_input_saldo_awal').modal('hide');
                                $('#form_input_saldo_awal').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_input_saldo_awal').html('Edit');
                                $("#btn_input_saldo_awal").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_input_saldo_awal').html('Edit');
                                    $("#btn_input_saldo_awal").removeAttr("disabled");
                                }
                    });

    });

    $(document).on('click', '.edit_saldo_awal', function() {
          var saldo_awal_id = $(this).attr('saldo_awal_id');
          var saldo_awal = $(this).attr('saldo_awal');

          var nm_item = $(this).attr('nm_item');

          $('#saldo_awal_id_edit').val(saldo_awal_id);

          $('#saldo_awal_edit').val(saldo_awal);

          $('#edit_saldo_awal_label').text('Edit Saldo Awal ' +nm_item);
      });

      $(document).on('submit', '#form_edit_saldo_awal', function(event) {
                event.preventDefault();
                    $('#btn_edit_saldo_awal').attr('disabled',true);
                    $('#btn_edit_saldo_awal').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('editSaldoAwal') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_edit_saldo_awal").removeAttr("disabled");
                                $('#btn_edit_saldo_awal').html('Edit'); //tombol simpan
                                $('#modal_edit_saldo_awal').modal('hide');
                                $('#form_edit_saldo_awal').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_edit_saldo_awal').html('Edit');
                                $("#btn_edit_saldo_awal").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_edit_saldo_awal').html('Edit');
                                    $("#btn_edit_saldo_awal").removeAttr("disabled");
                                }
                    });

    });
      //endsaldo

      //stok_barang
      function getDataStokBarang(id_barang,jenis_data,cabang_id,bulan_tahun) {
      $('#table_stok_barang').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getDataStokBarang') }}",
                method:"GET",
                data:{id_barang:id_barang, jenis_data:jenis_data, cabang_id:cabang_id, bulan_tahun:bulan_tahun},
                success:function(data){
                  $('#table_stok_barang').html(data);
                  
                }

              });
      }

      $(document).on('click', '.stok_barang', function() {


                                
        

          var id_barang = $(this).attr('id_barang');
          var jenis_data = $(this).attr('jenis_data');
          var nm_item = $(this).attr('nm_item');
          var cabang_id = $('#cabang_id').val();
          var bulan_tahun = $('#bulan_tahun').val();

          getDataStokBarang(id_barang,jenis_data,cabang_id,bulan_tahun);

          $('#bahan_baku_id_stok').val(id_barang);
          $('#jenis_data_stok').val(jenis_data);
          $('#cabang_id_stok').val(cabang_id);

          $('#stok_barang_label').html('Stok Masuk '+nm_item);
          


      });
      

      var stok_barang = 1;
      $(document).on('click', '#tambah_input_stok_barang', function() {
        stok_barang = stok_barang + 1;
        var html_code = '<div class="row mt-2" id="row_stok_barang'+stok_barang+'">';

        html_code += '<div class="col-6"><div class="form-group"><input type="date" class="form-control form-control-sm" name="tgl_input[]" required></div></div>';
        html_code += '<div class="col-5"><div class="form-group"><input type="number" step=".01" class="form-control form-control-sm" name="debit_input[]" required></div></div>';

        html_code += '<div class="col-1"><button type="button" data-row="row_stok_barang' + stok_barang + '" class="btn btn-danger btn-sm remove_stok_barang">-</button></div>';

        html_code += "</div>";

        $('#tambah_table_stok_barang').append(html_code);
        
      });

      $(document).on('click', '.remove_stok_barang', function() {
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
      });

      $(document).on('submit', '#form_stok_barang', function(event) {
                event.preventDefault();
                    $('#btn_stok_barang').attr('disabled',true);
                    $('#btn_stok_barang').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('stokBarang') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                

                                var id_barang = $('#bahan_baku_id_stok').val();
                                var jenis_data = $('#jenis_data_stok').val();
                                getDataStokBarang(id_barang,jenis_data,cabang_id,bulan_tahun);
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                $('#tambah_table_stok_barang').html('');
                                
                                $("#btn_stok_barang").removeAttr("disabled");
                                $('#btn_stok_barang').html('Edit'); //tombol simpan
                                // $('#modal_stok_barang').modal('hide');
                                
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_stok_barang').html('Edit');
                                $("#btn_stok_barang").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_stok_barang').html('Edit');
                                    $("#btn_stok_barang").removeAttr("disabled");
                                }
                    });

    });

  

      //end_stok_barang

      //stok_baku
      $(document).on('click', '.input_stok_baku', function() {

      var jenis_data = $(this).attr('jenis_data');
      var nm_item = $(this).attr('nm_item');
      var bahan_baku_id_stok_baku = $(this).attr('id_barang');
      var cabang_id = $('#cabang_id').val();

  
      $('#jenis_data_stok_baku').val(jenis_data);
      $('#cabang_id_stok_baku').val(cabang_id);

      $('#bahan_baku_id_stok_baku').val(bahan_baku_id_stok_baku);

      $('#input_stok_baku_label').html('Stok Baku '+nm_item);

      });

      $(document).on('submit', '#form_input_stok_baku', function(event) {
                event.preventDefault();
                    $('#btn_input_stok_baku').attr('disabled',true);
                    $('#btn_input_stok_baku').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('inputStokBaku') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_input_stok_baku").removeAttr("disabled");
                                $('#btn_input_stok_baku').html('Edit'); //tombol simpan
                                $('#modal_input_stok_baku').modal('hide');
                                $('#form_input_stok_baku').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_input_stok_baku').html('Edit');
                                $("#btn_input_stok_baku").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_input_stok_baku').html('Edit');
                                    $("#btn_input_stok_baku").removeAttr("disabled");
                                }
                    });

    });


    $(document).on('click', '.edit_stok_baku', function() {

    var stok_baku_id = $(this).attr('stok_baku_id');
    var nm_item = $(this).attr('nm_item');
    var stok_baku = $(this).attr('stok_baku');
    
    


    $('#stok_baku_id').val(stok_baku_id);
    $('#stok_baku').val(stok_baku);
    $('#edit_stok_baku_label').html('Stok Baku '+nm_item);

    });


    $(document).on('submit', '#form_edit_stok_baku', function(event) {
                event.preventDefault();
                    $('#btn_edit_stok_baku').attr('disabled',true);
                    $('#btn_edit_stok_baku').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('editStokBaku') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                var cabang_id = $('#cabang_id').val();
                                var bulan_tahun = $('#bulan_tahun').val();
                                getMsPengeluaran(cabang_id,bulan_tahun);
                                
                                $("#btn_edit_stok_baku").removeAttr("disabled");
                                $('#btn_edit_stok_baku').html('Edit'); //tombol simpan
                                $('#modal_edit_stok_baku').modal('hide');
                                $('#form_edit_stok_baku').trigger("reset");
                                

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil diedit'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_edit_stok_baku').html('Edit');
                                $("#btn_edit_stok_baku").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_edit_stok_baku').html('Edit');
                                    $("#btn_edit_stok_baku").removeAttr("disabled");
                                }
                    });

    });
      //end stok baku


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
  
