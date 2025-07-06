@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Users Kasir</h4>
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
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-user">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah User
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Outlet</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($user_kasir as $u)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $u->name }}</td>
                                      <td>{{ $u->username }}</td>
                                      <td>{{ $u->cabang_id != 0 ? $u->cabang->nama : '' }}</td>
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
  <form action="{{ route('addUserKasir') }}" method="post">
    @csrf
<div class="modal fade" id="add-user" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12 col-md-6">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukan nama" required>
                </div>

                <div class="col-12 col-md-6">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukan username" required>
                </div>

                <div class="col-12 col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukan password" required>
                </div>

                <div class="col-12 col-md-6">
                    <label>Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>

                <div class="col-12">
                    <label>Outlet</label>
                    <select name="cabang_id" class="form-control select2bs4" required>
                        <option value="" >-Pilih Outlet-</option>
                        @foreach ($outlet as $o)
                        <option value="{{ $o->id }}" >{{ $o->nama }}</option> 
                        @endforeach
                      </select>
                </div>

                

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

    <?php if($errors->any()): ?>
    Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              icon: 'error',
              title: ' Ada data yang tidak sesuai, periksa kembali'
            });            
    <?php endif; ?>                  
    
  });
</script>
@endsection
@endsection  
  
