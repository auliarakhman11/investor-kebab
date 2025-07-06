@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List bahan dan satuan</h4>
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
                      <h4 class="float-left">Data Bahan</h4>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal" data-target="#add-bahan">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Bahan
                          </button>

                          <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#sort-bahan">
                            <i class="fas fa-sort-amount-up-alt"></i>
                            Urutkan Bahan
                          </button>
                          
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bahan</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Jenis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($bahan as $b)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $b->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $b->bahan }}</td>
                                      <td>{{ $b->satuan->satuan }}</td>
                                      <td>
                                      @if ($b->hargaBahan)
                                            @foreach ($b->hargaBahan as $h)
                                                {{ $h->kota->nm_kota }} : {{ number_format($h->harga,0) }} <br>
                                            @endforeach
                                        @endif
                                        </td>
                                      <td>{{ number_format($b->harga_beli,0) }}</td>
                                      <td>{{ $b->jenisBahan->nm_jenis }}</td>
                                                                           
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-bahan{{ $b->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>

                                        <form class="d-inline-block" action="{{ route('dropDataBahan') }}" method="post">
                                          @csrf
                                          @method('patch')
                                          <input type="hidden" name="id" value="{{ $b->id }}">
                                          <button class="btn btn-xs ml-2 btn-danger" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data bahan?')"><i class="fas fa-trash"></i> </button>
                                        </form>

                                        {{-- <form class="d-inline-block" action="{{ route('dropKaryawan') }}" method="post">
                                          @csrf
                                          <input type="hidden" name="id" value="{{ $b->id }}">
                                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')" class="btn btn-xs btn-primary">
                                              <i class="fas fa-trash"></i> 
                                            </button>
                                        </form> --}}
                                      </td>
                                    </tr>
                                  @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-4">
                <div class="card">

                    <div class="card-header">
                      <h4 class="float-left">Data Satuan</h4>
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add-satuan">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Satuan
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Satuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($satuan as $s)
                                    <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $s->foto }}" alt="" height="40px"></td> --}}
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $s->satuan }}</td>
                                                                           
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-satuan{{ $s->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>

                                        {{-- <form class="d-inline-block" action="{{ route('dropKaryawan') }}" method="post">
                                          @csrf
                                          <input type="hidden" name="id" value="{{ $b->id }}">
                                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')" class="btn btn-xs btn-primary">
                                              <i class="fas fa-trash"></i> 
                                            </button>
                                        </form> --}}
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

  <div class="modal fade" id="sort-bahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Urutkan Bahan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Bahan</th>
                </tr>
              </thead>
              <tbody id="tbody_sort">
                @foreach ($bahan as $p)
                    <tr data-index="{{ $p->id }}" data-position="{{ $p->position }}">
                      <td>{{ $p->bahan }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah</button> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<form action="{{ route('addBahan') }}" method="post">
    @csrf
<div class="modal fade" id="add-bahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Bahan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label>Bahan</label>
                    <input type="text" name="bahan" class="form-control" placeholder="Masukan bahan" required>
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
                
                <div class="col-12">
                  <label>Jenis</label>
                  <select class="form-control select2bs4" name="jenis_bahan_id" required>
                      <option value="">-Pilih Jenis-</option>
                      @foreach ($jenis_bahan as $j)
                      <option value="{{ $j->id }}">{{ $j->nm_jenis }}</option>
                      @endforeach
                  </select>
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


@foreach ($bahan as $b)
<form action="{{ route('editBahan') }}" method="post">
    @csrf
    @method('patch')
<div class="modal fade" id="edit-bahan{{ $b->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Bahan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <input type="hidden" name="id" value="{{ $b->id }}">
                <div class="col-12">
                    <label>Bahan</label>
                    <input type="text" name="bahan" class="form-control" placeholder="Masukan bahan" value="{{ $b->bahan }}" required>
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
                  <input type="number" name="harga_beli" class="form-control" placeholder="Masukan harga" value="{{ $b->harga_beli }}" required>
              </div>
                
                <div class="col-12">
                  <label>Jenis</label>
                  <select class="form-control select2bs4" name="jenis_bahan_id" required>
                      @foreach ($jenis_bahan as $j)
                      <option value="{{ $j->id }}" {{ $j->id == $b->jenis_bahan_id ? 'selected' : '' }}>{{ $j->nm_jenis }}</option>
                      @endforeach
                  </select>
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

                <input type="number" class="form-control" name="harga[]" value="{{ $index + 1 > count($b->hargaBahan)  ? 0 : $b->hargaBahan[$index]->harga }}">
              </div>

              <div class="col-lg-6 mb-2 text-center">
                <label for="">
                  <dt style="font-size: 13px;">Stok Baku</dt>
                </label>
                <input type="number" class="form-control" name="stok_baku[]" value="{{ $index + 1 > count($b->hargaBahan)  ? 0 : $b->hargaBahan[$index]->stok_baku }}">
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

                <input type="number" class="form-control" name="harga_mitra[]" value="{{ $index + 1 > count($b->hargaBahanMitra)  ? 0 : $b->hargaBahanMitra[$index]->harga }}">
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

<form action="{{ route('addSatuan') }}" method="post">
    @csrf
<div class="modal fade" id="add-satuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Satuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="Masukan satuan" required>
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

@foreach ($satuan as $s)
<form action="{{ route('editSatuan') }}" method="post">
    @csrf
    @method('patch')
<div class="modal fade" id="edit-satuan{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Satuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <input type="hidden" name="id" value="{{ $s->id }}">
                <div class="col-12">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="Masukan satuan" value="{{ $s->satuan }}" required>
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
    
    
    function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
               positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
               $(this).removeClass('updated');
            });

            $.ajax({
               url: "{{ route('sortBahan') }}",
               method: 'POST',
               dataType: 'text',
               data: {
                   update: 1,
                   positions: positions
               }, success: function (response) {
                    console.log(response);
               }
            });
        }

    $('#tbody_sort').sortable({
               update: function (event, ui) {
                   $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                   });

                   saveNewPositions();
               }
           });
    
  });
</script>
@endsection
@endsection  
  
