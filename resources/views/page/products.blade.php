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
                  @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif

                  @if (session('error'))
                  <div class="alert alert-danger">
                      {{ session('error') }}
                  </div>
                  @endif
                    <div class="card-header">
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal" data-target="#add-product">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Produk
                          </button>
                          <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#sort-product">
                            <i class="fas fa-sort-amount-up-alt"></i>
                            Urutkan Produk
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table_produk">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Kategori</th>
                                        <th>Diskon</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($produk as $p)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $p->nm_produk }}</td>
                                      <td>{{ $p->kategori->kategori }}</td>
                                      <td>{{ $p->diskon }}%</td>
                                      <td>
                                        @if ($p->getHarga)
                                            @foreach ($p->getHarga as $h)
                                                {{ $h->delivery->delivery }} : {{ number_format($h->harga,0) }} <br>
                                            @endforeach
                                        @endif
                                      </td>
                                      <td class="{{ ($p->status == 'ON' ? 'text-success' : 'text-danger') }}">{{ $p->status }}</td>
                                      
                                      <td>
                                        <button type="button" class="btn btn-xs btn-warning resep" data-toggle="modal" data-target="#resep" produk-id="{{ $p->id }}" nm-produk="{{ $p->nm_produk }}">
                                          Resep
                                        </button>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-product{{ $p->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>
                                        <a href="{{ route('deleteProduk',$p->id) }}" onclick="return confirm('Aoakah yakin ingin menghapus produk?')" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></a>
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


  <div class="modal fade" id="sort-product" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Urutkan Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Produk</th>
                </tr>
              </thead>
              <tbody id="tbody_sort">
                @foreach ($produk as $p)
                    <tr data-index="{{ $p->id }}" data-position="{{ $p->position }}">
                      <td>{{ $p->nm_produk }}</td>
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
  <form action="{{ route('addProduct') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="add-product" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
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
                        <div class="col-lg-4 mb-2">
                            <label for="">
                                <dt>Nama Produk</dt>
                            </label>
                            <input type="text" name="nm_produk" class="form-control" placeholder="Nama Produk" required>
                        </div>

                        <div class="col-lg-4 mb-2">
                          <label for="">
                              <dt>Kategori</dt>
                          </label>
                          <select name="kategori_id" class="form-control" required>
                            @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->kategori }}</option> 
                            @endforeach
                          </select>
                      </div>

                      <div class="col-lg-4 mb-2">
                        <label for="">
                            <dt>Status</dt>
                        </label>
                        <select name="status" class="form-control" required>
                          <option value="ON" >ON</option>
                          <option value="OFF" >OFF</option>
                        </select>
                    </div>
                      
                        <div class="col-4"></div>
                        <div class="col-4 text-center"><label for=""><dt>Harga</dt></label></div>
                        <div class="col-4"></div>
                        
                        @foreach ($delivery as $d)
                          <div class="col-lg-4 mb-2 text-center">
                            <label for="">
                                <dt>{{ $d->delivery }}</dt>
                            </label>
                            <input type="hidden" name="delivery_id[]" value="{{ $d->id }}">
                            <input type="number" class="form-control" name="harga[]" value="0">
                          </div>
                        @endforeach
                        
                        <div class="col-12 text-center"><label for=""><dt>Kota</dt></label></div>

                      @foreach ($kota as $k)
                          <div class="col-4">
                            <label for="{{ $k->nm_kota.$k->id }}"><input type="checkbox" id="{{ $k->nm_kota.$k->id }}" value="{{ $k->id }}" name="kota_id[]" > {{ $k->nm_kota }}</label>
                          </div>
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

@foreach ($produk as $p)
<form action="{{ route('editProduk') }}" method="post" enctype="multipart/form-data">
  @method('patch')
  @csrf
<div class="modal fade" id="edit-product{{ $p->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
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
                      <div class="col-lg-4 mb-2">
                          <label for="">
                              <dt>Nama Produk</dt>
                          </label>
                          <input type="text" name="nm_produk" value="{{ $p->nm_produk }}" class="form-control" placeholder="Nama Produk" required>
                      </div>

                      <div class="col-lg-4 mb-2">
                        <label for="">
                            <dt>Kategori</dt>
                        </label>
                        <select name="kategori_id" class="form-control" required>
                          @foreach ($kategori as $k)
                          <option value="{{ $k->id }}" {{ $k->id == $p->kategori->id ? 'selected' : '' }}>{{ $k->kategori }}</option> 
                          @endforeach
                        </select>
                    </div>

                      {{-- <div class="col-lg-4 mb-2">
                          <label for="">
                              <dt>Diskon</dt>
                          </label>
                          <input type="number" class="form-control" name="diskon" value="{{ $p->diskon }}" placeholder="cth : 5" required>
                      </div> --}}

                      <div class="col-lg-4 mb-2">
                        <label for="">
                            <dt>Status</dt>
                        </label>
                        <select name="status" class="form-control" required>
                          <option value="ON" {{ $p->status == 'ON' ? 'selected' : '' }}>ON</option>
                          <option value="OFF" {{ $p->status == 'OFF' ? 'selected' : '' }}>OFF</option>
                        </select>
                    </div>
                    
                      <div class="col-4"></div>
                      <div class="col-4 text-center"><label for=""><dt>Harga</dt></label></div>
                      <div class="col-4"></div>
                      
                      @foreach ($delivery as $index => $d)
                        <div class="col-lg-4 mb-2 text-center">
                          <label for="">
                              <dt>{{ $d->delivery }}</dt>
                          </label>
                          <input type="hidden" name="delivery_id[]" value="{{ $d->id }}">

                          <input type="number" class="form-control" name="harga[]" value="{{ $index + 1 > count($p->getHarga)  ? 0 : $p->getHarga[$index]->harga }}">
                        </div>
                      @endforeach

                      <div class="col-12 text-center"><label for=""><dt>Kota</dt></label></div>
                      @php
                          $dtProdukKota = [];
                      @endphp
                      @if ($p->produkKota)
                        @foreach ($p->produkKota as $pk)
                          @php
                              $dtProdukKota [] = $pk->kota_id
                          @endphp
                        @endforeach
                      @endif

                      
                      @foreach ($kota as $k)
                          <div class="col-4">
                            <label for="{{ $k->nm_kota.$k->id.$p->id }}"><input id="{{ $k->nm_kota.$k->id.$p->id }}" type="checkbox" value="{{ $k->id }}" name="kota_id[]" {{ in_array($k->id, $dtProdukKota) ? 'checked' : '' }} > {{ $k->nm_kota }}</label>
                          </div>
                      @endforeach

                      

                      
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

  <!-- Modal -->
  <form id="input_resep">
    @csrf
<div class="modal fade" id="resep" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="header-resep"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" name="produk_id" id="produk_id">
        <div class="modal-body" id="form-resep">
            
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
               url: "{{ route('sortProduk') }}",
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


    function getResep(id){
      $.ajax({
                url:"{{ route('getResep') }}",
                method:"GET",
                data:{id:id},
                success:function(data){
                  $('#form-resep').html(data);

                  $('.select2bs4').select2({
                      theme: 'bootstrap4',
                      tags: true,
                  });
                }

              });
    }

      $(document).on('click', '.resep', function() {
        var id = $(this).attr("produk-id");
        var nm_produk = $(this).attr("nm-produk");

        $('#header-resep').html('Resep '+nm_produk);
        $('#produk_id').val(id);

        getResep(id);  

      });

    var count_bahan = 1;
    $(document).on('click', '#tambah-bahan', function() {
      count_bahan = count_bahan + 1;
      var html_code = '<div class="row" id="row'+count_bahan+'">';

      html_code += '<div class="col-6"><div class="form-group"><select name="bahan_id[]"  class="form-control select2bs4" required><option value="">-Pilih Bahan-</option><?php foreach ($bahan as $b) : ?><option value="<?= $b->id; ?>"><?= $b->bahan; ?></option><?php endforeach; ?> </select></div></div>';

      html_code += '<div class="col-5"><div class="form-group"><input type="number" name="takaran[]" class="form-control" required></div></div>';

      html_code += '<div class="col-1"><button type="button" data-row="row' + count_bahan + '" class="btn btn-danger btn-sm remove_bahan">-</button></div>';

      html_code += "</div>";

      $('#tambah-resep').append(html_code);
      $('.select2bs4').select2({
                      theme: 'bootstrap4',
                      tags: true,
                  });
    });

    $(document).on('click', '.remove_bahan', function() {
      var delete_row = $(this).data("row");
      $('#' + delete_row).remove();
    });

    $(document).on('submit', '#input_resep', function(event) {
        event.preventDefault();
        var id = $('#produk_id').val();
            $.ajax({
                url:"{{ route('addResep') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    getResep(id);
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Resep berhasil dibuat'
                    });  
                }
            });

        });

        $(document).on('click', '.hapus-resep', function() {
        var produk_id = $(this).attr("produk-id");
        var id = $(this).attr("id-resep");

        
          $.ajax({
                url:"{{ route('dropResep') }}",
                method:"POST",
                data:{id:id},
                success:function(data){
                  getResep(produk_id);  
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Resep berhasil dihapus'
                    }); 
                }

              });

        

      });
    
  });
</script>
@endsection
@endsection  
  
