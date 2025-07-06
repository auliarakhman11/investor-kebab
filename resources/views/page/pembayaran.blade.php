@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Daftar Pembayaran</h4>
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
            <div class="col-8">
                <div class="card">
                  {{-- @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif --}}
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#add-pembayaran">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Pembayaran
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>                                 
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($pembayaran as $pb)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $pb->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $pb->pembayaran }}</td>
                                      <td class="{{ $pb->aktif == '1' ? 'text-success' : 'text-danger' }}">{{ $pb->aktif == '1' ? 'Aktif' : 'Non Aktif' }}</td>

                                      
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-pembayaran{{ $pb->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>
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
  <form action="{{ route('addPembayaran') }}" method="post">
    @csrf
<div class="modal fade" id="add-pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-6">
                    <label>Pembayaran</label>
                    <input type="text" name="pembayaran" class="form-control" placeholder="Masukan Pembayaran" required>
                </div>
  
                <div class="col-6 mb-2">
                      <label for="">
                          <dt>Status</dt>
                      </label>
                      <select name="aktif" class="form-control" required>
  
                      <option value="1">Aktif</option>
                      <option value="0">Non Aktif</option> 
                      
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


@foreach ($pembayaran as $pb)
<form action="{{ route('editPembayaran') }}" method="post">
  @csrf
  @method('patch')
<div class="modal fade" id="edit-pembayaran{{ $pb->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">
            <input type="hidden" name="id" value="{{ $pb->id }}">
              <div class="col-6">
                  <label>Pembayaran</label>
                  <input type="text" name="pembayaran" value="{{ $pb->pembayaran }}" class="form-control" placeholder="Masukan Pembayaran" required>
              </div>

              <div class="col-6 mb-2">
                    <label for="">
                        <dt>Status</dt>
                    </label>
                    <select name="aktif" class="form-control" required>

                    <option value="1" {{ $pb->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $pb->aktif == 0 ? 'selected' : '' }}>Non Aktif</option> 
                    
                    </select>
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
{{-- @foreach ($post as $p)
<form action="{{ route('editPost') }}" method="post" enctype="multipart/form-data">
  @method('patch')
  @csrf
<div class="modal fade" id="edit-post{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" value="{{ $p->id }}">
      <div class="modal-body">
          <div class="row form-group ">
              <div class="col-sm-4">
                  <label for="">Masukkan Gambar</label>
                  <input type="file" class="dropify text-sm" data-default-file="{{ asset('') }}{{ $p->foto }}" name="foto" placeholder="Image">
              </div>
              <div class="col-lg-8">
                  <div class="form-group row">
                      <div class="col-lg-12 mb-2">
                          <label for="">
                              <dt>Caption</dt>
                          </label>
                          <input type="text" name="caption" class="form-control" placeholder="Caption" value="{{ $p->caption }}" required>
                      </div>
                      <div class="col-lg-12 mb-2">
                          <label for="">
                              <dt>Content</dt>
                          </label>
                          <textarea class="form-control" name="content" rows="5" required>{{ $p->content }}</textarea>
                          
                      </div>
                                       
                      
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
@endforeach --}}

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
    
  });
</script>
@endsection
@endsection  
  
