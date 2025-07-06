@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Post</h4>
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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-product">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Post
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Capton</th>
                                        <th>Content</th>
                                        <th>Foto</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($post as $p)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $p->caption }}</td>
                                      <td>{{ $p->content }}</td>
                                      <td><img src="{{ asset('') }}{{ $p->foto }}" alt="" height="40px"></td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-post{{ $p->id }}">
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
  <form action="{{ route('addPost') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row form-group ">
                <div class="col-sm-4">
                    <label for="">Masukkan Gambar</label>
                    <input type="file" class="dropify text-sm" data-default-file="{{ asset('img') }}/kebabyasmin.jpeg" name="foto" placeholder="Image" required>
                </div>
                <div class="col-lg-8">
                    <div class="form-group row">
                        <div class="col-lg-12 mb-2">
                            <label for="">
                                <dt>Caption</dt>
                            </label>
                            <input type="text" name="caption" class="form-control" placeholder="Caption" required>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label for="">
                                <dt>Content</dt>
                            </label>
                            <textarea class="form-control" name="content" rows="5" required></textarea>
                            
                        </div>
                                         
                        
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

@foreach ($post as $p)
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
    
  });
</script>
@endsection
@endsection  
  
