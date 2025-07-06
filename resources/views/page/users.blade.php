@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Users Management</h4>
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
                                        <th>Posisi</th>
                                        <th>Kota</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($users as $u)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $u->name }}</td>
                                      <td>{{ $u->username }}</td>
                                      <td>{{ $u->posisi->posisi }}</td>
                                      <td>
                                        @if ($u->aksesKota)
                                            @foreach ($u->aksesKota as $a)
                                                {{ $a->kota->nm_kota }},
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                      </td>
                                      <td>{{ $u->aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-user{{ $u->id }}">
                                          <i class="fas fa-users-cog"></i> 
                                        </button>
                                        <a href="{{ route('deleteUser',$u->id) }}" onclick="return confirm('Apakah yakin ingin menghapus user?')" class="btn btn-xs btn-danger ml-1"><i class="fas fa-trash"></i></a>
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
  <form action="{{ route('addUser') }}" method="post">
    @csrf
<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                <div class="col-12 col-md-6">
                    <label>Posisi</label>
                    <select name="role" class="form-control" required>
                      <option value="">-Pilih Posisi-</option>
                      @foreach ($posisi as $p)
                        <option value="{{ $p->id }}">{{$p->posisi}}</option>
                      @endforeach
                    </select>
                </div>
                
                <div class="col-12 col-md-6">
                  <label for="">Kota</label>
                  <div class="row">
                    <div class="col-12"><label for=""><input type="checkbox" id="check_all_kota" value="" name=""> All</label></div>
                    @foreach ($kota as $k)
                    <div class="col-12"><label for=""><input type="checkbox" class="kota" value="{{ $k->id }}" name="kota_id[]"> {{ $k->nm_kota }}</label></div>
                    @endforeach
                    
                  </div>
                                                      
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

@foreach ($users as $u)
<form action="{{ route('editUser') }}" method="post">
  @csrf
  @method('patch')
<div class="modal fade" id="edit-user{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Akses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">
            <input type="hidden" name="id" value="{{ $u->id }}">
              <div class="col-12 col-md-6">
                  <label>Posisi</label>
                  <select name="role" class="form-control" required>
                    @foreach ($posisi as $p)
                      <option value="{{ $p->id }}" {{$u->role == $p->id ? 'selected' : ''}}>{{$p->posisi}}</option>
                    @endforeach
                  </select>
              </div>

              <div class="col-12 col-md-6">
                <label>Status</label>
                <select name="aktif" class="form-control" required>
                 @if ($u->aktif)
                     <option value="1" selected>Aktif</option>
                     <option value="0">Tidak Aktif</option>
                 @else
                    <option value="1">Aktif</option>
                    <option value="0" selected>Tidak Aktif</option>
                 @endif
                </select>
              </div>
              
              <div class="col-12">
                <label for="">Kota</label>
                <div class="row">
                  <div class="col-4"><label for=""><input type="checkbox" id="check_all_kota" value="" name=""> All</label></div>
                  @if ($u->aksesKota)
                    @foreach ($kota as $k)
                    @php
                        $nilai = 0;
                    @endphp
                        @foreach ($u->aksesKota as $ak)
                            @if ($ak->kota_id == $k->id)
                            @php
                                $nilai++
                            @endphp                            
                            @endif
                        @endforeach
                        @if ($nilai)
                        <div class="col-4"><label for=""><input type="checkbox" class="kota" value="{{ $k->id }}" name="kota_id[]" checked> {{ $k->nm_kota }}</label></div>
                        @else
                        <div class="col-4"><label for=""><input type="checkbox" class="kota" value="{{ $k->id }}" name="kota_id[]"> {{ $k->nm_kota }}</label></div>
                        @endif             
                        
                    @endforeach
                  @else
                    @foreach ($kota as $k)                  
                    <div class="col-12"><label for=""><input type="checkbox" class="kota" value="{{ $k->id }}" name="kota_id[]"> {{ $k->nm_kota }}</label></div>
                    @endforeach
                  @endif
                  
                  
                </div>
                                                    
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
@endforeach



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

    <?php if(session('error_kota')): ?>
    Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              icon: 'error',
              title: "{{ session('error_kota') }}"
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
    
    $(document).on('click', '#check_all_kota', function() {
      if (this.checked) {
        $('.kota').prop('checked',true);
      }else{
        $('.kota').prop('checked',false);
      }      
      
      });

      $(document).on('click', '.kota', function() {

        $('#check_all_kota').prop('checked',false);
            
      
      });
    
  });
</script>
@endsection
@endsection  
  
