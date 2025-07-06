@extends('template.master')
@section('content')

<style>
  .scroll {
    overflow-x: auto;
    height:400px;
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
            {{-- <h4 class="m-0">Audit</h4> --}}
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
              <div class="card-header">
                <h5 class="float-left">Gaji Crew & Office</h5>
                <button type="button" data-toggle="modal" data-target="#modal_gaji_crew" id="btn_gaji_crew" class="btn btn-sm btn-primary float-right ml-2">Gaji Crew</button>
                <button type="button" data-toggle="modal" data-target="#modal_gaji_office" id="btn_gaji_office" class="btn btn-sm btn-primary float-right ml-2">Gaji Office</button>
              </div>
              <div class="card-body">
                <div id="table_list-data-gaji"></div>
                <div class="mt-2" id="table_list_gaji_office"></div>
              </div>
            </div>

            
          </div>

        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

{{-- <form id="form_audit">
  @csrf --}}
  <div class="modal fade" id="modal_edit_list_gaji" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="exampleModalLabel">List Gaji</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="table_edit_list_gaji">

          
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="submit" class="btn btn-primary" id="btn_audit">Audit</button> --}}
        </div>
      </div>
    </div>
  </div>
{{-- </form> --}}

<div class="modal fade" id="modal_edit_list_gaji_office" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">List Gaji Office</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="table_edit_list_gaji_office">

        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="submit" class="btn btn-primary" id="btn_audit">Audit</button> --}}
      </div>
    </div>
  </div>
</div>

<form id="form_gaji">
  @csrf
<div class="modal fade" id="modal_gaji_crew" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Gaji Crew</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="table_edit_list_gaji">

        
            <div class="card">

              <div class="card-header">

                <div class="row">
                  <div class="col-4"><h4 class="float-left">Gaji Crew</h4></div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="">Dari</label>
                      <input type="date" name="tgl1" id="tgl1" value="{{ date('Y-m-01') }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-4">
                      <div class="form-group">
                        <label for="">Sampai</label>
                        <input type="date" name="tgl2" id="tgl2" value="{{ date('Y-m-t') }}" class="form-control">
                      </div>
                  </div>
                </div>
                    
              </div>
              <div class="card-body scroll" style="padding-top: 0;" id="table_gaji">
                  
              </div>
          </div>
        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_save_gaji">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>


<form id="form_gaji_office">
  @csrf
<div class="modal fade" id="modal_gaji_office" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Gaji Office</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="table_edit_list_gaji">

        
            <div class="card">

              <div class="card-header">

                <div class="row">
                  <div class="col-4"><h4 class="float-left">Gaji Office</h4></div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="">Dari</label>
                      <input type="date" name="tgl1" id="tgl1_office" value="{{ date('Y-m-01') }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-4">
                      <div class="form-group">
                        <label for="">Sampai</label>
                        <input type="date" name="tgl2" id="tgl2_office" value="{{ date('Y-m-t') }}" class="form-control">
                      </div>
                  </div>
                </div>
                    
              </div>
              <div class="card-body scroll" style="padding-top: 0;" id="table_gaji_office">
                  
              </div>
          </div>
        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_save_gaji_office">Simpan</button>
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
    
    // var tgl1 = $('#tgl1').val();
    // var tgl2 = $('#tgl2').val();

    listDataGaji();
    listDataGajiOffice();

    $(document).on('click', '#btn_gaji_crew', function() {
          var tgl1 = $("#tgl1").val();
          var tgl2 = $("#tgl2").val();
          listGaji(tgl1,tgl2);
          
      });

      $(document).on('click', '#btn_gaji_office', function() {
          var tgl1 = $("#tgl1_office").val();
          var tgl2 = $("#tgl2_office").val();
          listGajiOffice(tgl1,tgl2);
          
      });

      // $(document).on('click', '#list-data-gaji-tab', function() {
      //   listDataGaji();
      // });


    function listGaji(tgl1,tgl2){
      $('#table_gaji').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('listGaji') }}",
                method:"GET",
                data:{tgl1:tgl1,tgl2:tgl2},
                success:function(data){
                  $('#table_gaji').html(data);

                }

              });
    }

    function listDataGaji(){
      $('#table_list-data-gaji').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('listDataGaji') }}",
                method:"GET",
                success:function(data){
                  $('#table_list-data-gaji').html(data);

                }

              });
    }

    function listGajiOffice(tgl1,tgl2){
      $('#table_gaji_office').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('listGajiOffice') }}",
                method:"GET",
                data:{tgl1:tgl1,tgl2:tgl2},
                success:function(data){
                  $('#table_gaji_office').html(data);

                }

              });
    }

    function listDataGajiOffice(){
      $('#table_list_gaji_office').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('listDataGajiOffice') }}",
                method:"GET",
                success:function(data){
                  $('#table_list_gaji_office').html(data);

                }

              });
    }

    // function listDataGajiOffice(){
    //   $('#table_gaji_office').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
    //   $.ajax({
    //             url:"{{ route('listDataGajiOffice') }}",
    //             method:"GET",
    //             success:function(data){
    //               $('#table_list_gaji_office').html(data);

    //             }

    //           });
    // }

    

    

    $(document).on('change', '#tgl1', function() {
          var tgl1 = $(this).val();
          var tgl2 = $("#tgl2").val();
          listGaji(tgl1,tgl2);
          
      });
    
      $(document).on('change', '#tgl2', function() {
          var tgl2 = $(this).val();
          var tgl1 = $("#tgl1").val();
          listGaji(tgl1,tgl2);
          
      });


      $(document).on('change', '#tgl1_office', function() {
          var tgl1 = $(this).val();
          var tgl2 = $("#tgl2_office").val();
          listGajiOffice(tgl1,tgl2);
          
      });
    
      $(document).on('change', '#tgl2_office', function() {
          var tgl2 = $(this).val();
          var tgl1 = $("#tgl1_office").val();
          listGajiOffice(tgl1,tgl2);
          
      });

      $(document).on('keyup', '.persen', function() {
          var urutan = $(this).attr('karyawan_id');
          var persen1 = $('#persen1'+urutan).val() ? parseInt($('#persen1'+urutan).val()) : 0;
          var persen2 = $('#persen2'+urutan).val() ? parseInt($('#persen2'+urutan).val()) : 0;
          var pendapatan = $('#pendapatan'+urutan).val() ? parseInt($('#pendapatan'+urutan).val()) : 0;
          var gapok = $('#gapok'+urutan).val() ? parseInt($('#gapok'+urutan).val()) : 0;
          var kasbon = $('#kasbon'+urutan).val() ? parseInt($('#kasbon'+urutan).val()) : 0;

          var total_persen = persen1 + persen2;
          
          var total_gaji_persen = parseInt((total_persen * pendapatan)/100);
          
          var thp = gapok + total_gaji_persen - kasbon;

          $("#total_persen"+urutan).html(total_persen +"%");
          $("#total_gaji_persen" + urutan).val(total_gaji_persen);
          $(".total_gaji_persen" + urutan).html(total_gaji_persen.toLocaleString('en-US'));
          $("#thp").val(thp);
          $(".thp" + urutan).html(thp.toLocaleString('en-US'));
              
      });

      $(document).on('submit', '#form_gaji', function(event){  
           event.preventDefault();
            $('#btn_save_gaji').attr('disabled',true);
            $('#btn_save_gaji').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
            $.ajax({  
                     url:"{{ route('saveGaji') }}",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                        $("#btn_save_gaji").removeAttr("disabled");
                        $('#btn_save_gaji').html('Save'); //tombol simpan

                        $('#modal_gaji_crew').modal('hide');

                        // var tgl1 = $('#tgl1').val();
                        // var tgl2 = $('#tgl2').val();

                        // listGaji(tgl1,tgl2);

                        listDataGaji();

                        Swal.fire({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000,
                          icon: 'success',
                          title: ' Data gaji berhasil disimpan'
                        }); 

                     }  ,
                        error: function (err) { //jika error tampilkan error pada console
                          console.log(err);
                          $("#btn_save_gaji").removeAttr("disabled");
                          $('#btn_save_gaji').html('Save'); //tombol simpan
                        }
                }); 

            });


            $(document).on('click', '.delete_list_gaji', function() {
                var kd_gabungan = $(this).attr('kd_gabungan');
                
                if (confirm('Apakah anda yakin ingin menghapus data gaji?')) {
                  $.ajax({
                    url:"{{ route('deleteListGaji') }}",
                    method:"GET",
                    data:{kd_gabungan:kd_gabungan},
                    success:function(data){
                      listDataGaji();

                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000,
                          icon: 'success',
                          title: ' Data gaji berhasil dihapus'
                        });

                    }

                  }); 
                }


            });

            $(document).on('click', '.delete_list_gaji_office', function() {
                var kd_gabungan = $(this).attr('kd_gabungan');
                
                if (confirm('Apakah anda yakin ingin menghapus data gaji?')) {
                  $.ajax({
                    url:"{{ route('deleteListGajiOffice') }}",
                    method:"GET",
                    data:{kd_gabungan:kd_gabungan},
                    success:function(data){
                      listDataGajiOffice();

                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000,
                          icon: 'success',
                          title: ' Data gaji berhasil dihapus'
                        });

                    }

                  }); 
                }


            });

            $(document).on('click', '.edit_list_gaji', function() {
                var kd_gabungan = $(this).attr('kd_gabungan');

                $('#table_edit_list_gaji').html('Loading <div class="ld"><div></div><div></div><div></div></div>');

                $.ajax({
                    url:"{{ route('editListGaji') }}",
                    method:"GET",
                    data:{kd_gabungan:kd_gabungan},
                    success:function(data){
                      $('#table_edit_list_gaji').html(data);
                    }

                  }); 

            });


            $(document).on('click', '.edit_list_gaji_office', function() {
                var kd_gabungan = $(this).attr('kd_gabungan');

                $('#table_edit_list_gaji_office').html('Loading <div class="ld"><div></div><div></div><div></div></div>');

                $.ajax({
                    url:"{{ route('editListGajiOffice') }}",
                    method:"GET",
                    data:{kd_gabungan:kd_gabungan},
                    success:function(data){
                      $('#table_edit_list_gaji_office').html(data);
                    }

                  }); 

            });


            $(document).on('submit', '#form_gaji_office', function(event){  
           event.preventDefault();
            $('#btn_save_gaji_office').attr('disabled',true);
            $('#btn_save_gaji_office').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
            $.ajax({  
                     url:"{{ route('saveGajiOffice') }}",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                        $("#btn_save_gaji_office").removeAttr("disabled");
                        $('#btn_save_gaji_office').html('Save'); //tombol simpan

                        $('#modal_gaji_office').modal('hide');

                        // var tgl1 = $('#tgl1').val();
                        // var tgl2 = $('#tgl2').val();

                        // listGaji(tgl1,tgl2);

                        listDataGajiOffice();

                        Swal.fire({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000,
                          icon: 'success',
                          title: ' Data gaji berhasil disimpan'
                        }); 

                     }  ,
                        error: function (err) { //jika error tampilkan error pada console
                          console.log(err);
                          $("#btn_save_gaji_office").removeAttr("disabled");
                          $('#btn_save_gaji_office').html('Save'); //tombol simpan
                        }
                }); 

            });
    
  });
</script>
@endsection
@endsection  
  
