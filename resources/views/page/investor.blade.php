@extends('template.master')
@section('content')

@php
  $tgl1 = date('Y-m-01');
  $tgl2 = date('Y-m-t');
@endphp

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
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                          <a class="nav-link active" id="laba_rugi-tab" data-toggle="tab" href="#laba_rugi" role="tab" aria-controls="laba_rugi" aria-selected="true">Laba Rugi</a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link" id="per_outlet-tab" data-toggle="tab" href="#per_outlet" role="tab" aria-controls="per_outlet" aria-selected="false">Per Outlet</a>
                        </li>
                        
        
        
                      </ul>

                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="laba_rugi-tab" id="laba_rugi">
                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_laba_rugi" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_laba_rugi" class="form-control">
                            </div>

                          </div>
                          <div id="laba_rugi_table"></div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="per_outlet-tab" id="per_outlet">
                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_per_outlet" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_per_outlet" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Outlet</label>
                              <select id="cabang_id_per_outlet" class="form-control">
                                @foreach ($cabang as $cb)
                                    <option value="{{ $cb->id }}">{{ $cb->nama }}</option>
                                @endforeach
                              </select>
                            </div>

                          </div>
                          <div id="per_outlet_table"></div>
                        </div>

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


    var tgl1_laba_rugi = $('#tgl1_laba_rugi').val();
    var tgl2_laba_rugi = $('#tgl2_laba_rugi').val();

    dtJurnal(tgl1_laba_rugi,tgl2_laba_rugi);


    function dtJurnal(tgl1, tgl2){
      $('#laba_rugi_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtJurnal') }}",
                method:"GET",
                data:{tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#laba_rugi_table').html(data);

                }

              });
    }

    function dtPeroutlet(cabang_id,tgl1, tgl2){
      $('#per_outlet_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtPeroutlet') }}",
                method:"GET",
                data:{cabang_id:cabang_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#per_outlet_table').html(data);

                }

              });
    }


    $(document).on('click', '#per_outlet-tab', function() {
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl1 = $('#tgl1_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });


    

    $(document).on('click', '#laba_rugi-tab', function() {
          var tgl1 = $('#tgl1_laba_rugi').val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnal(tgl1, tgl2);
          
      });

      //peroutlet
      $(document).on('change', '#tgl1_per_outlet', function() {
        var tgl1 = $(this).val();
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_per_outlet', function() {
        var tgl2 = $(this).val();
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl1 = $('#tgl1_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#cabang_id_per_outlet', function() {
          var cabang_id = $(this).val();
          var tgl1 = $('#tgl1_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });
      //end peroutlet

      $(document).on('change', '#tgl1_laba_rugi', function() {
        var tgl1 = $(this).val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnal(tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_laba_rugi', function() {
        var tgl2 = $(this).val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          dtJurnal(tgl1, tgl2);
          
      });

     
    
  });
</script>
@endsection
@endsection  
  
