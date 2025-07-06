@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Barang Kebutuhan</h4>
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
                      <h4 class="float-left">Data Barang</h4>
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-barang">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Barang
                          </button>
                          
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Barang</th>
                                        <th>Satuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($barang as $b)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $b->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $b->nm_barang }}</td>
                                      <td>{{ $b->satuan->satuan }}</td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-barang{{ $b->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>

                                        <form class="d-inline-block" action="{{ route('dropBarangKebutuhan') }}" method="post">
                                          @csrf
                                          @method('patch')
                                          <input type="hidden" name="id" value="{{ $b->id }}">
                                          <button class="btn btn-xs ml-2 btn-danger" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data bahan?')"><i class="fas fa-trash"></i> </button>
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
<form action="{{ route('addBarangKebutuhan') }}" method="post">
    @csrf
<div class="modal fade" id="add-barang" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label>Barang</label>
                    <input type="text" name="nm_barang" class="form-control" placeholder="Masukan barang" required>
                </div>

                <div class="col-12">
                    <label>Satuan</label>
                    <select class="form-control select2bs4" name="satuan_id" required>
                        <option value="">-Pilih Satuan-</option>
                        @foreach ($satuan as $s)
                        <option value="{{ $s->id }}">{{ $s->satuan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                  <label>Harga Beli</label>
                  <input type="number" name="harga_beli" class="form-control" placeholder="Masukan harga" required>
                </div>

                <div class="col-4"><hr></div>
                <div class="col-4 text-center"><strong><u>Manager Store</u></strong></div>
                <div class="col-4"><hr></div>

                @foreach ($kota as $index => $d)
                <div class="col-12 mb-2 text-center"><dt>{{ $d->nm_kota }}</dt></div>
                <div class="col-lg-6 mb-2 text-center">
                  <label for="">
                      <dt style="font-size: 13px;">Harga Jual</dt>
                  </label>
                  <input type="hidden" name="kota_id[]" value="{{ $d->id }}">

                  <input type="number" class="form-control" name="harga[]" value="0">
                </div>

                <div class="col-lg-6 mb-2 text-center">
                  <label for="">
                      <dt style="font-size: 13px;">Stok Baku</dt>
                  </label>
                  <input type="number" class="form-control" name="stok_baku[]" value="0">
                </div>

                <div class="col-12"><hr></div>
                @endforeach

                <div class="col-5"><hr></div>
                <div class="col-2 text-center"><strong><u>Mitra</u></strong></div>
                <div class="col-5"><hr></div>

                @foreach ($mitra as $index => $d)
                <div class="col-lg-4 mb-2 text-center">
                  <label for=""><dt>{{ $d->nm_mitra }}</dt></label>
                  
                  <input type="hidden" name="mitra_id[]" value="{{ $d->id }}">

                  <input type="number" class="form-control" name="harga_mitra[]" value="0">
                </div>
                @endforeach

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


@foreach ($barang as $b)
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
                  <label>Harga Beli</label>
                  <input type="number" name="harga" class="form-control" placeholder="Masukan harga" value="{{ $b->harga_beli }}" required>
                </div>
                
                @foreach ($kota as $index => $d)
                <div class="col-12 mb-2 text-center"><dt>{{ $d->nm_kota }}</dt></div>
                <div class="col-lg-6 mb-2 text-center">
                  <label for="">
                      <dt style="font-size: 13px;">Harga Jual</dt>
                  </label>
                  <input type="hidden" name="kota_id[]" value="{{ $d->id }}">

                  <input type="number" class="form-control" name="harga[]" value="{{ $index + 1 > count($b->hargaKebutuhan)  ? 0 : $b->hargaKebutuhan[$index]->harga }}">
                </div>


                <div class="col-lg-6 mb-2 text-center">
                  <label for="">
                      <dt style="font-size: 13px;">Stok Baku</dt>
                  </label>
                  <input type="number" class="form-control" name="stok_baku[]" value="{{ $index + 1 > count($b->hargaKebutuhan)  ? 0 : $b->hargaKebutuhan[$index]->stok_baku }}">
                </div>
                @endforeach

                <div class="col-5"><hr></div>
                <div class="col-2 text-center"><strong><u>Mitra</u></strong></div>
                <div class="col-5"><hr></div>

                @foreach ($mitra as $index => $d)
                <div class="col-lg-4 mb-2 text-center">
                  <label for=""><dt>{{ $d->nm_mitra }}</dt></label>
                  
                  <input type="hidden" name="mitra_id[]" value="{{ $d->id }}">

                  <input type="number" class="form-control" name="harga_mitra[]" value="{{ $index + 1 > count($b->hargaKebutuhanMitra)  ? 0 : $b->hargaKebutuhanMitra[$index]->harga }}">
                </div>
                @endforeach

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
  
