@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Outlet</h4>
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
                        <button type="button" class="btn btn-primary btn-sm float-right ml-2" data-toggle="modal" data-target="#add-product">
                            <i class="fas fa-plus-circle"></i> 
                            Tambah Outlet
                          </button>

                          <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#sort-outlet">
                            <i class="fas fa-sort-amount-up-alt"></i>
                            Urutkan Outlet
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Outlet</th>
                                        <th>Kota</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>No Telpon</th>
                                        <th>Email</th>
                                        <th>Event</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($outlet as $o)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $o->nama }}</td>
                                      <td>{{ $o->nm_kota }}</td>
                                      <td class="text-center">{{ $o->alamat }}</td>
                                      <td><img src="{{ asset('') }}{{ $o->foto }}" alt="" height="40px"></td>
                                      <td>{{ $o->no_tlpn }}</td>
                                      <td>Gojek: {{ $o->email_gojek }}<br>
                                        Grab: {{ $o->email_grab }}<br>
                                        Shopee: {{ $o->email_shopee }}
                                      </td>
                                      
                                      <td>
                                        @if ($o->event == 1)
                                            <p class="text-danger">OFF</p>
                                        @else
                                        <p class="text-success">ON</p>
                                        @endif
                                      </td>
                                      <td>
                                        @if ($o->off == 1)
                                            <p class="text-danger">OFF</p>
                                        @else
                                        <p class="text-success">ON</p>
                                        @endif
                                      </td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary mr-2" data-toggle="modal" data-target="#edit{{ $o->id }}">
                                        <i class="fas fa-edit"></i> 
                                      </button>

                                      <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#harga{{ $o->id }}">
                                        <i class="fas fa-file-invoice-dollar"></i>
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

  <div class="modal fade" id="sort-outlet" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Urutkan Outlet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Outlet</th>
                </tr>
              </thead>
              <tbody id="tbody_sort">
                @foreach ($outlet as $p)
                    <tr data-index="{{ $p->id }}" data-position="{{ $p->position }}">
                      <td>{{ $p->nama }}</td>
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
  <form action="{{ route('addOutlet') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Outlet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row form-group ">
                <div class="col-4 col-sm-4">
                    <label for="">Masukkan Gambar</label>
                    <input type="file" class="dropify text-sm" data-default-file="{{ asset('img') }}/kebabyasmin.jpeg" name="foto" placeholder="Image">
                </div>
                <div class="col-8 col-lg-8">
                    <div class="form-group row">
                        <div class=" col-6 mb-2">
                            <label for="">
                                <dt>Nama Outlet</dt>
                            </label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required>
                        </div>

                        <div class="col-6 mb-2">
                            <label>Kota</label>
                            <select name="kota_id" class="form-control select2bs4" required>
                                <option value="" >-Pilih Kota-</option>
                                @foreach ($kota as $k)
                                <option value="{{ $k->id }}" >{{ $k->nm_kota }}</option> 
                                @endforeach
                              </select>
                        </div>

                        

                            <div class="col-lg-6 mb-2">
                                <label for="">
                                    <dt>Alamat Outlet</dt>
                                </label>
                                {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                <textarea class="form-control" name="alamat" rows="5" required ></textarea>
                            </div>
                            
                            <div class="col-lg-6 mb-2">
                              <label for="">
                                  <dt>Url Google Map</dt>
                              </label>
                              {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                              <textarea class="form-control" name="map" rows="5"></textarea>
                          </div>

                          <div class="col-6 mb-2">
                              <label>Zona Waktu</label>
                              <select name="time_zone" class="form-control" required>
                                  
                                <option value="Asia/Makassar" >WITA</option> 
                                <option value="Asia/Jakarta" >WIB</option> 
                                  
                                </select>
                          </div>

                          <div class="col-6 mb-2">
                            <label>Aktif</label>
                            <select name="off" class="form-control" required>
                                
                              <option value="0" >ON</option> 
                              <option value="1" >OFF</option> 
                                
                              </select>
                        </div>

                          <div class=" col-6 mb-2">
                            <label for="">
                                <dt>Nomor Telpon</dt>
                            </label>
                            <input type="number" name="no_tlpn" class="form-control">
                        </div>

                        <div class=" col-6 mb-2">
                          <label for="">
                              <dt>Email Gojek</dt>
                          </label>
                          <input type="email" name="email_gojek" class="form-control" >
                      </div>

                      <div class=" col-6 mb-2">
                        <label for="">
                            <dt>Email Grab</dt>
                        </label>
                        <input type="email" name="email_grab" class="form-control" >
                    </div>

                    <div class=" col-6 mb-2">
                      <label for="">
                          <dt>Email Shopee</dt>
                      </label>
                      <input type="email" name="email_shopee" class="form-control" >
                  </div>

                          <div class="col-6 mb-2">
                              <label>Event</label>
                              <select name="event" class="form-control select2bs4" required>
                                  <option value="0">Tidak</option>
                                  <option value="1">Ya</option>
                                </select>
                          </div>

                  {{-- <div class=" col-6 mb-2">
                      <label for="">
                          <dt>Gapok Sehari</dt>
                      </label>
                      <input type="number" name="gapok" class="form-control">
                  </div> --}}

                  @foreach ($akun as $index => $d)
                  
                  <div class="col-8 mb-1">
                    <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
                    <label for="">{{ $d->nm_akun }}</label>
                  </div>
                  <div class="col-4 mb-1">
                    <input type="number" name="harga[]" class="form-control" value="{{ $index + 1 > count($o->hargaPengeluaran)  ? 0 : $o->hargaPengeluaran[$index]->harga }}" required>
                  </div>
                  <div class="col-12"><hr></div>
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

@foreach ($outlet as $o)
    <!-- Modal -->
  <form action="{{ route('editOutlet') }}" method="post" enctype="multipart/form-data">
    
    @method('patch')
    @csrf
<div class="modal fade" id="edit{{ $o->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Outlet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row form-group ">
                <div class="col-4 col-sm-4">
                    <label for="">Masukkan Gambar</label>
                    <input type="file" class="dropify text-sm" data-default-file="{{ asset('') }}{{ $o->foto }}" name="foto" placeholder="Image">
                </div>
                <input type="hidden" name="id" value="{{ $o->id }}">
                <div class="col-8 col-lg-8">
                    <div class="form-group row">
                        <div class=" col-6 mb-2">
                            <label for="">
                                <dt>Nama Outlet</dt>
                            </label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" value="{{ $o->nama }}" required>
                        </div>

                        <div class="col-6 mb-2">
                            <label>Kota</label>
                            <select name="kota_id" class="form-control select2bs4" required>
                                <option value="" >-Pilih Kota-</option>
                                @foreach ($kota as $k)
                                <option value="{{ $k->id }}" {{ $o->kota_id == $k->id ? 'selected' : '' }} >{{ $k->nm_kota }}</option> 
                                @endforeach
                              </select>
                        </div>

                            <div class="col-lg-6 mb-2">
                                <label for="">
                                    <dt>Alamat Outlet</dt>
                                </label>
                                {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                <textarea class="form-control" name="alamat" rows="5">{{ $o->alamat }}</textarea>
                            </div>
                            
                            <div class="col-lg-6 mb-2">
                              <label for="">
                                  <dt>Url Google Map</dt>
                              </label>
                              {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                              <textarea class="form-control" name="map" rows="5">{{ $o->map }}</textarea>
                          </div>

                          <div class="col-6 mb-2">
                            <label>Zona Waktu</label>
                            <select name="time_zone" class="form-control" required>
                                @if ($o->time_zone == 'Asia/Makassar')
                                <option value="Asia/Makassar" selected>WITA</option>
                                <option value="Asia/Jakarta" >WIB</option>
                                @else
                                <option value="Asia/Makassar" >WITA</option>
                                <option value="Asia/Jakarta" selected>WIB</option> 
                                @endif  
                            </select>
                        </div>

                        <div class="col-6 mb-2">
                          <label>Aktif</label>
                          <select name="off" class="form-control" required>
                              @if ($o->off == 1)
                              <option value="1" selected>OFF</option>
                              <option value="0" >ON</option>
                              @else
                              <option value="1" >OFF</option>
                              <option value="0" selected>ON</option> 
                              @endif  
                          </select>
                      </div>

                          <div class=" col-6 mb-2">
                            <label for="">
                                <dt>Nomor Telpon</dt>
                            </label>
                            <input type="number" name="no_tlpn" class="form-control" value="{{ $o->no_tlpn }}">
                        </div>

                        <div class=" col-6 mb-2">
                          <label for="">
                              <dt>Email Gojek</dt>
                          </label>
                          <input type="email" name="email_gojek" class="form-control" value="{{ $o->email_gojek }}">
                      </div>

                      <div class=" col-6 mb-2">
                        <label for="">
                            <dt>Email Grab</dt>
                        </label>
                        <input type="email" name="email_grab" class="form-control" value="{{ $o->email_grab }}">
                    </div>

                    <div class=" col-6 mb-2">
                      <label for="">
                          <dt>Email Shopee</dt>
                      </label>
                      <input type="email" name="email_shopee" class="form-control" value="{{ $o->email_shopee }}">
                  </div>

                          <div class="col-6 mb-2">
                            <label>Event</label>
                            <select name="event" class="form-control select2bs4" required>
                                <option value="0" {{ $o->event != 1 ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $o->event == 1 ? 'selected' : '' }}>Ya</option>
                              </select>
                        </div>
                  
                      {{-- <div class=" col-6 mb-2">
                          <label for="">
                              <dt>Gapok Sehari</dt>
                          </label>
                          <input type="number" name="gapok" value="{{ $o->gapok }}" class="form-control">
                      </div> --}}
                  
                        
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

<form action="{{ route('editHargaPengeluaran') }}" method="post">
  @csrf
  <div class="modal fade" id="harga{{ $o->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Harga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" name="cabang_id" value="{{ $o->id }}">
              @foreach ($akun as $d)

              @php
                  $ada=0;
              @endphp

              @foreach ($o->hargaPengeluaran as $oh)
                  @if ($oh->akun_id == $d->id)
                  <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
                  <div class="col-8 mb-1">
                    <label for="">{{ $d->nm_akun }}</label>
                  </div>
                  <div class="col-4 mb-1">
                    <input type="number" name="harga[]" class="form-control" value="{{ $oh->harga }}">
                  </div>
                  <div class="col-12"><hr></div>
                  @php
                      $ada++;
                  @endphp                  
                  @endif
              @endforeach

              @if (!$ada)
              <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
              <div class="col-8 mb-1">
                <label for="">{{ $d->nm_akun }}</label>
              </div>
              <div class="col-4 mb-1">
                <input type="number" name="harga[]" class="form-control" value="0">
              </div>
              <div class="col-12"><hr></div>
              @endif
              
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

{{-- <form action="{{ route('editHargaPengeluaran') }}" method="post">
  @csrf
  <div class="modal fade" id="harga{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Harga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" name="cabang_id" value="{{ $o->id }}">
              @foreach ($akun as $index => $d)
              <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
              <div class="col-8 mb-1">
                <label for="">{{ $d->nm_akun }}</label>
              </div>
              <div class="col-4 mb-1">
                <input type="number" name="harga[]" class="form-control" value="{{ $index + 1 > count($o->hargaPengeluaran)  ? 0 : $o->hargaPengeluaran[$index]->harga }}" required>
              </div>
              <div class="col-12"><hr></div>
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
</form> --}}


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
    
    
    function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
               positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
               $(this).removeClass('updated');
            });

            $.ajax({
               url: "{{ route('sortOutlet') }}",
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
  
