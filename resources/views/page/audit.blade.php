@extends('template.master')
@section('content')
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

                      <div class="row">
                        <div class="col-md-8 col-6"><h4 class="float-left">Audit</h4></div>
                        <div class="col-md-4 col-6">
                          <select id="tanggal" class="form-control">
                            @foreach ($tanggal as $t)
                                <option value="{{ $t->tgl }}">{{ date("d M Y", strtotime($t->tgl)) }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                        {{-- <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-akun">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Akun
                          </button> --}}
                          
                    </div>
                    <div class="card-body" id="table_audit">
                        
                    </div>
                </div>
            </div>




        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


{{-- @foreach ($barang as $b)
<form action="{{ route('editBarangKebutuhan') }}" method="post">
    @csrf
    @method('patch')
<div class="modal fade" id="edit-barang{{ $b->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <input type="hidden" name="id" value="{{ $b->id }}">
                <div class="col-12">
                    <label>Barang</label>
                    <input type="text" name="nm_barang" class="form-control" placeholder="Masukan Barang" value="{{ $b->nm_barang }}" required>
                </div>

                <div class="col-12">
                    <label>Satuan</label>
                    <select class="form-control select2bs4" name="satuan_id" required>
                        @foreach ($satuan as $s)
                        <option value="{{ $s->id }}" {{ $s->id == $b->satuan_id ? 'selected' : '' }}>{{ $s->satuan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                  <label>Harga Jual</label>
                  <input type="number" name="harga" class="form-control" placeholder="Masukan harga" value="{{ $b->harga }}" required>
                </div>

                <div class="col-12">
                  <label>Harga Beli</label>
                  <input type="number" name="harga_beli" class="form-control" placeholder="Masukan harga" value="{{ $b->harga_beli }}" required>
                </div>
            

            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endforeach --}}

<form id="form_audit">
  @csrf
  <div class="modal fade" id="modal_audit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="exampleModalLabel">Audit Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="input_audit">

          
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_audit">Audit</button>
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
    
    var tanggal = $('#tanggal').val();

    listJaga(tanggal);


    function listJaga(tanggal){
      $('#table_audit').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('listJaga') }}",
                method:"GET",
                data:{tanggal:tanggal},
                success:function(data){
                  $('#table_audit').html(data);

                }

              });
    }

    $(document).on('change', '#tanggal', function() {
          var tanggal = $(this).val();
          listJaga(tanggal);
          
      });

      $(document).on('click', '.btn_audit', function() {
          var karyawan_id = $(this).attr('karyawan_id');
          var cabang_id = $(this).attr('cabang_id');
          var buka_toko_id = $(this).attr('buka_toko_id');
          var tanggal = $('#tanggal').val();
          $('#input_audit').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
          $.ajax({
                    url:"{{ route('inputAudit') }}",
                    method:"GET",
                    data:{tanggal:tanggal, cabang_id:cabang_id, buka_toko_id:buka_toko_id, karyawan_id:karyawan_id},
                    success:function(data){
                      $('#input_audit').html(data);

                    }

                  });
              
      });

      $(document).on('submit', '#form_audit', function(event){  
           event.preventDefault();
            $('#btn_audit').attr('disabled',true);
            $('#btn_audit').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
            $.ajax({  
                     url:"{{ route('addAudit') }}",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                        $('#modal_audit').modal('hide');
                        $("#btn_audit").removeAttr("disabled");
                        $('#btn_audit').html('Audit'); //tombol simpan

                        var tanggal = $('#tanggal').val();
                        listJaga(tanggal);
                     }  ,
                        error: function (err) { //jika error tampilkan error pada console
                          console.log(err);
                          $("#btn_audit").removeAttr("disabled");
                          $('#btn_audit').html('Audit'); //tombol simpan
                        }
                }); 

            });
    
  });
</script>
@endsection
@endsection  
  
