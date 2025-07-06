@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Akun Pengeluaran</h4>
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

                    <div class="card-header">
                      <h4 class="float-left">Akun Pengeluaran</h4>
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-akun">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Akun
                          </button>
                          
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Akun</th>
                                        <th>Jenis Akun</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($akun as $a)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $a->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $a->nm_akun }}</td>
                                      <td>{{ $a->jenisAkun->jenis_akun }}</td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-akun{{ $a->id }}">
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
<form action="{{ route('addAkun') }}" method="post">
    @csrf
<div class="modal fade" id="add-akun" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label>Nama Akun</label>
                    <input type="text" name="nm_akun" class="form-control" placeholder="Masukan barang" required>
                </div>

                <div class="col-12">
                    <label>Jenis Akun</label>
                    <select class="form-control select2bs4" name="jenis_akun_id" required>
                        <option value="">-Pilih Jenis-</option>
                        @foreach ($jenis_akun as $j)
                        <option value="{{ $j->id }}">{{ $j->jenis_akun }}</option>
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

@foreach ($akun as $a)
<form action="{{ route('editAkun') }}" method="post">
  @csrf
  @method('patch')
<div class="modal fade" id="edit-akun{{ $a->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">
            <input type="hidden" name="id" value="{{ $a->id }}">
              <div class="col-12">
                  <label>Nama Akun</label>
                  <input type="text" name="nm_akun" class="form-control" placeholder="Masukan barang" value="{{ $a->nm_akun }}" required>
              </div>

              <div class="col-12">
                  <label>Jenis Akun</label>
                  <select class="form-control select2bs4" name="jenis_akun_id" required>
                      @foreach ($jenis_akun as $j)
                      <option value="{{ $j->id }}" {{ $a->id == $j->id ? 'selected' : '' }}>{{ $j->jenis_akun }}</option>
                      @endforeach
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
    
  });
</script>
@endsection
@endsection  
  
