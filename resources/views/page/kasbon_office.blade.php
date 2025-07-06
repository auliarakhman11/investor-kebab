@extends('template.master')
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
            {{-- <h4 class="m-0">List Kasbon</h4> --}}
          </div>
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol> --}}
          </div>
        </div>
      </div>
    </div>

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

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <h4 class="m-0">List Kasbon Office</h4>
                        </div>
                        
                        <div class="col-md-2 col-6  text-center">
                          
                        </div>
                        <div class="col-md-2 col-6 text-center">
                          <label for="">Dari</label>
                          <input type="date" id="tgl1" class="form-control" value="{{ date('Y-m-').'01' }}">
                        </div>
                        <div class="col-md-2 col-6 text-center">
                          <label for="">Sampai</label>
                          <input type="date" id="tgl2" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-2 col-6 mt-4">
                          <button type="button" class="btn btn-sm btn-primary float-left mt-2" data-toggle="modal" data-target="#add-kasbon">
                              <i class="fas fa-plus-circle"></i> 
                              Tambah
                            </button>
                        </div>

                      </div>

                  </div>
                  <div class="card-body scroll" id="table_kasbon">
                      
                  </div>
              </div>


            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <form id="form_kasbon">
    @csrf
<div class="modal fade" id="add-kasbon" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kasbon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
            <div class="row">

                <div class="col-12">
                    <label for="">Tanggal</label>
                    <input type="date" name="tgl" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="col-12">
                    <label for="">Karyawan</label>
                    <select name="karyawan_id"  class="form-control select2bs4" required>
                        <option value="">-Pilih-</option>
                        @foreach ($karyawan as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach                
                    </select>
                </div>

                <div class="col-12">
                    <label for="">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_add_kasbon">Tambah</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form id="form_edit_kasbon">
  @csrf
<div class="modal fade" id="edit-kasbon" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kasbon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit_kasbon">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_edit_kasbon">Edit</button>
      </div>
    </div>
  </div>
</div>
</form>


@section('script')
<script>
  $(document).ready(function() {

    
    var tgl1 = $('#tgl1').val();
    var tgl2 = $('#tgl2').val();

    getDataKasbon(tgl1, tgl2);

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

    function getDataKasbon(tgl1, tgl2){
      $('#table_kasbon').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.get('get-data-kasbon-office/' + tgl1 + '/' + tgl2, function (data) {        
              $('#table_kasbon').html(data);
              // console.log(kota_id + ' ' + tgl1 + ' ' + tgl2);
            });
    }
    
    $(document).on('click', '.btn_edit', function() {
            var karyawan_id = $(this).attr('karyawan_id');
            
            var tgl1 = $('#tgl1').val();
            var tgl2 = $('#tgl2').val();
            $('#edit_kasbon').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
            $.get('get-kasbon-office/'+ karyawan_id + '/' + tgl1 + '/' + tgl2, function (data) {        
              $('#edit_kasbon').html(data);
              // console.log(kota_id + ' ' + tgl1 + ' ' + tgl2);
            });
            
        });

        // $(document).on('click', '.btn_edit', function() {
        //     var karyawan_id = $(this).attr('karyawan_id');
        //     
        //     var tgl1 = $('#tgl1').val();
        //     var tgl2 = $('#tgl2').val();
        //     $('#edit_kasbon').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
        //     $.get('get-kasbon/'+ karyawan_id + '/' + kota_id + '/' + tgl1 + '/' + tgl2, function (data) {        
        //       $('#edit_kasbon').html(data);
        //       // console.log(kota_id + ' ' + tgl1 + ' ' + tgl2);
        //     });
            
        // });

        $(document).on('click', '.btn_delete', function() {

          if (confirm('Apakah anda yakin ingin menghapus data?')) {
              var id = $(this).attr('id_kasbon');
            
              $.get('drop-kasbon-office/' + id, function (data) {

                
                var tgl1 = $('#tgl1').val();
                var tgl2 = $('#tgl2').val();

                getDataKasbon(tgl1, tgl2);

                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Data berhasil dihapus'
                      });

                      $('#edit-kasbon').modal('hide');

              });
          }  

        });
    
    $(document).on('change', '#tgl1', function() {
        
        var tgl1 = $(this).val();
        var tgl2 = $('#tgl2').val();
        
        getDataKasbon(tgl1, tgl2);
        
    });

    $(document).on('change', '#tgl2', function() {
        
        var tgl1 = $('#tgl1').val();
        var tgl2 = $(this).val();
        
        getDataKasbon(tgl1, tgl2);
        
    });

    $(document).on('submit', '#form_kasbon', function(event) {
                event.preventDefault();
                    $('#btn_add_kasbon').attr('disabled',true);
                    $('#btn_add_kasbon').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('addKasbonOffice') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                $("#btn_add_kasbon").removeAttr("disabled");
                                $('#btn_add_kasbon').html('Tambah'); //tombol simpan
                  
                                $('#add-kasbon').modal('hide'); //modal show

                                var tgl1 = $('#tgl1').val();
                                var tgl2 = $('#tgl2').val();

                                $('#form_kasbon').trigger("reset");

                                getDataKasbon(tgl1, tgl2);

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
                                $('#btn_add_kasbon').html('Tambah');
                                $("#btn_add_kasbon").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_add_kasbon').html('Tambah');
                                    $("#btn_add_kasbon").removeAttr("disabled");
                                }
                    });
    });


    $(document).on('submit', '#form_edit_kasbon', function(event) {
                event.preventDefault();
                    $('#btn_edit_kasbon').attr('disabled',true);
                    $('#btn_edit_kasbon').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                    $.ajax({
                        url:"{{ route('editKasbonOffice') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                $("#btn_edit_kasbon").removeAttr("disabled");
                                $('#btn_edit_kasbon').html('Edit'); //tombol simpan
                  
                                $('#edit-kasbon').modal('hide'); //modal show

                                
                                var tgl1 = $('#tgl1').val();
                                var tgl2 = $('#tgl2').val();

                                getDataKasbon(tgl1, tgl2);

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
                                $('#btn_edit_kasbon').html('Edit');
                                $("#btn_edit_kasbon").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $('#btn_edit_kasbon').html('Edit');
                                    $("#btn_edit_kasbon").removeAttr("disabled");
                                }
                    });
    });

    
  });
</script>
@endsection
@endsection  
  
