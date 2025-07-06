@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Products</h4>
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
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-varian">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Varian
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Varian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($varian as $v)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $v->nm_varian }}</td>
                                      <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-varian{{ $v->id }}">
                                        <i class="fas fa-edit"></i> 
                                      </button></td>                                     
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
    <form action="{{ route('addVarian') }}" method="post">
        @csrf
    <div class="modal fade" id="add-varian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Varian</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
    
                <div class="row">
    
                    <div class="col-12 ">
                        <label>Varian</label>
                        <input type="text" name="nm_varian" class="form-control" placeholder="Masukan varian" required>
                    </div>
    
                    {{-- <div class="col-4 mb-2">
                        <label>Jenis</label>
                        <select class="form-control" name="kategori_varian_id"  required>
                            @foreach ($kategori_varian as $v)
                                <option value="{{ $v->id }}">{{ $v->kategori_varian }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <input type="hidden" name="kategori_varian_id" value="1">
                    
                    <div class="col-12">
                        <label>Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control" placeholder="Masukan harga">
                    </div>

                    <div class="col-4"><hr></div>
                    <div class="col-4 text-center"><strong><u>Manager Store</u></strong></div>
                    <div class="col-4"><hr></div>

                    @foreach ($kota as $index => $d)
                    <div class="col-12 mb-2 text-center">
                      <label for="">
                        <dt>{{ $d->nm_kota }}</dt>
                      </label>
                    </div>
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
                      <label for="">
                        <dt>{{ $d->nm_mitra }}</dt>
                      </label>
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

    @foreach ($varian as $v)
    <form action="{{ route('editVarian') }}" method="post">
      @csrf
      @method('patch')
      <div class="modal fade" id="edit-varian{{ $v->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $v->nm_varian }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
      
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="">Varian</label>
                        <input type="text" name="nm_varian" class="form-control form-control-sm" value="{{ $v->nm_varian }}" required>
                        <input type="hidden" name="id" value="{{ $v->id }}">
                      </div>
                      
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label for="">Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control form-control-sm" value="{{ $v->harga_beli }}" required>
                      </div>
                      
                    </div>

                    <div class="col-4"><hr></div>
                    <div class="col-4 text-center"><strong><u>Manager Store</u></strong></div>
                    <div class="col-4"><hr></div>
                    
                    @foreach ($kota as $index => $d)
                    <div class="col-12 mb-2 text-center">
                      <label for="">
                        <dt>{{ $d->nm_kota }}</dt>
                      </label>
                    </div>
                    <div class="col-lg-6 mb-2 text-center">
                      <label for="">
                          <dt style="font-size: 13px;">Harga Jual</dt>
                      </label>
                      <input type="hidden" name="kota_id[]" value="{{ $d->id }}">

                      <input type="number" class="form-control" name="harga[]" value="{{ $index + 1 > count($v->hargaVarian)  ? 0 : $v->hargaVarian[$index]->harga }}">
                    </div>

                    <div class="col-lg-6 mb-2 text-center">
                      <label for="">
                          <dt style="font-size: 13px;">Stok Baku</dt>
                      </label>
                      <input type="number" class="form-control" name="stok_baku[]" value="{{ $index + 1 > count($v->hargaVarian)  ? 0 : $v->hargaVarian[$index]->stok_baku }}">
                    </div>
                    @endforeach

                    <div class="col-5"><hr></div>
                    <div class="col-2 text-center"><strong><u>Mitra</u></strong></div>
                    <div class="col-5"><hr></div>

                    @foreach ($mitra as $index => $d)
                    <div class="col-lg-4 mb-2 text-center">
                      <label for="">
                        <dt>{{ $d->nm_mitra }}</dt>
                      </label>
                      <input type="hidden" name="mitra_id[]" value="{{ $d->id }}">

                      <input type="number" class="form-control" name="harga_mitra[]" value="{{ $index + 1 > count($v->hargaVarianMitra)  ? 0 : $v->hargaVarianMitra[$index]->harga }}">
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
    
  });
</script>
@endsection
@endsection  
  
