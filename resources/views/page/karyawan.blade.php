@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Karyawan</h4>
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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-karyawan">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Karyawan
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>No Tlp</th>
                                        <th>Alamat</th>
                                        <th>Tgl_masuk</th>
                                        <th>Gapok</th>
                                        <th>Kota</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($karyawan as $k)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $k->nama }}</td>
                                      <td>{{ $k->no_tlp }}</td>
                                      <td>{{ $k->alamat }}</td>
                                      <td>{{ $k->tgl_masuk ? date("d M Y", strtotime($k->tgl_masuk)) : '-' ; }}</td>
                                      <td>{{ number_format($k->gapok,0) }}</td>
                                      <td>{{ $k->kota->nm_kota }}</td>
                                      
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-karyawan{{ $k->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>

                                        <form class="d-inline-block" action="{{ route('dropKaryawan') }}" method="post">
                                          @csrf
                                          <input type="hidden" name="id" value="{{ $k->id }}">
                                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')" class="btn btn-xs btn-primary">
                                              <i class="fas fa-trash"></i> 
                                            </button>
                                        </form>
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
  <form action="{{ route('addKaryawan') }}" method="post">
    @csrf
<div class="modal fade" id="add-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12 col-md-6">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan nama" required>
                </div>

                <div class="col-12 col-md-6">
                    <label>No Telephon</label>
                    <input type="number" name="no_tlp" class="form-control" placeholder="Masukan nomor" >
                </div>

                <div class="col-12 col-md-6">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" style="font-size: 12px;" class="form-control" placeholder="Masukan tanggal masuk" >
                </div>

                <div class="col-12 col-md-6">
                  <label>Gapok Perbulan</label>
                  <input type="number" name="gapok" style="font-size: 12px;" class="form-control" placeholder="Masukan gapok" >
                </div>

                <div class="col-12 col-md-6">
                  <label>Kota</label>
                  <select name="kota_id" class="form-control" required>
                    @foreach ($kota as $d)
                        <option value="{{ $d->id }}">{{ $d->nm_kota }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12 col-md-12">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" rows="5" ></textarea>
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


@foreach ($karyawan as $k)
<form action="{{ route('editKaryawan') }}" method="post">
  @csrf
  @method('patch')
<div class="modal fade" id="edit-karyawan{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">
            <input type="hidden" name="id" value="{{ $k->id }}">
              <div class="col-12 col-md-6">
                  <label>Nama</label>
                  <input type="text" name="nama" value="{{ $k->nama }}" class="form-control" placeholder="Masukan nama" required>
              </div>

              <div class="col-12 col-md-6">
                  <label>No Telephon</label>
                  <input type="number" name="no_tlp" value="{{ $k->no_tlp }}" class="form-control" placeholder="Masukan nomor" >
              </div>

              <div class="col-12 col-md-6">
                  <label>Tanggal Masuk</label>
                  <input type="date" name="tgl_masuk" value="{{ $k->tgl_masuk }}" style="font-size: 12px;" class="form-control" placeholder="Masukan tanggal masuk" >
              </div>

              <div class="col-12 col-md-6">
                <label>Kota</label>
                <select name="kota_id" class="form-control" required>
                  @foreach ($kota as $d)
                      <option {{ $k->kota_id == $d->id ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nm_kota }}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6">
              <label>Gapok Perbulan</label>
              <input type="number" name="gapok" style="font-size: 12px;" value="{{ $k->gapok }}" class="form-control" placeholder="Masukan gapok" >
            </div>

              <div class="col-12 col-md-12">
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamat" rows="5" >{{ $k->alamat }}</textarea>
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
  
