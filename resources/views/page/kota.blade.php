@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Grand Manager</h4>
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
            <div class="col-6">
                <div class="card">
                  {{-- @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif --}}
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm float-right ml-2" data-toggle="modal" data-target="#add-gm">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Grand Manager
                          </button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Grand Manager</th>
                                        {{-- <th>Kota</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>No Telpon</th>
                                        <th>Email</th>
                                        <th>Event</th> --}}
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($kota as $k)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $k->nm_kota }}</td>
                                      
                                      <td>
                                        {{-- <button type="button" class="btn btn-xs btn-primary mr-2" data-toggle="modal" data-target="#edit{{ $k->id }}">
                                        <i class="fas fa-edit"></i> 
                                      </button> --}}

                                      {{-- <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#harga{{ $k->id }}">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                      </button> --}}
                                    </td>
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
  
  <form action="{{ route('addKota') }}" method="post">
    @csrf
<div class="modal fade" id="add-gm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Grand Manager</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label>Nama</label>
                    <input type="text" name="nm_kota" class="form-control" placeholder="Masukan Nama" required>
                </div>

              {{-- @foreach ($akun as $index => $d)
              <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
              <div class="col-8 mb-1">
                <label for="">{{ $d->nm_akun }}</label>
              </div>
              <div class="col-4 mb-1">
                <input type="number" name="harga[]" class="form-control" value="0" required>
              </div>
              @endforeach --}}

            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </div>
    </div>
  </div>
</form>



@foreach ($kota as $k)
<form action="{{ route('editHargaPengeluaran') }}" method="post">
  @csrf
  <div class="modal fade" id="harga{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Harga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" name="kota_id" value="{{ $k->id }}">
              {{-- @foreach ($akun as $index => $d)
              <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
              <div class="col-8 mb-1">
                <label for="">{{ $d->nm_akun }}</label>
              </div>
              <div class="col-4 mb-1">
                <input type="number" name="harga[]" class="form-control" value="{{ $index + 1 > count($k->hargaPengeluaran)  ? 0 : $k->hargaPengeluaran[$index]->harga }}" required>
              </div>
              <div class="col-12"><hr></div>
              @endforeach --}}
  
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


@endforeach

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
  
