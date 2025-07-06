@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Karyawan Office</h4>
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
                                        <th>Gapok</th>
                                        <th>Persen</th>
                                        <th>Alamat</th>
                                        <th>Tgl_masuk</th>
                                        <th>Outlet</th>
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
                                      <td>{{ $k->gapok }}</td>
                                      <td>{{ $k->persen }}%</td>
                                      <td>{{ $k->alamat }}</td>
                                      <td>{{ $k->tgl_masuk ? date("d M Y", strtotime($k->tgl_masuk)) : '-' ; }}</td>
                                      <td>
                                        @if ($k->karyawanOfficeKota)
                                            @foreach ($k->karyawanOfficeKota as $kt)
                                                {{ $kt->cabang->nama }} <br>
                                            @endforeach
                                        @endif
                                      </td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-karyawan{{ $k->id }}">
                                          <i class="fas fa-edit"></i> 
                                        </button>

                                        <form class="d-inline-block" action="{{ route('dropKaryawanOffice') }}" method="post">
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
<form action="{{ route('addKaryawanOffice') }}" method="post">
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
                  <label>Gaji Pokok Perbulan</label>
                  <input type="number" name="gapok" style="font-size: 12px;" class="form-control">
                </div>
                <div class="col-12 col-md-6">
                  <label>Persen</label>
                  <input type="text" name="persen" style="font-size: 12px;" class="form-control" required>
                </div>

                <div class="col-12 col-md-12">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" rows="5" ></textarea>
                </div>
                
                <div class="col-12 col-md-12">
                    <label for="">Outlet</label>
                    <div class="row">
                      <div class="col-4"><label for=""><input type="checkbox" id="check_all_kota" value="" name=""> All</label></div>
                      @foreach ($cabang as $k)
                      <div class="col-4"><label for=""><input type="checkbox" class="kota" value="{{ $k->id }}" name="cabang_id[]"> {{ preg_replace("/Kebab Yasmin/", "", $k->nama)  }}</label></div>
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


@foreach ($karyawan as $k)
<form action="{{ route('editKaryawanOffice') }}" method="post">
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
            <input type="hidden" name="karyawan_id" value="{{ $k->id }}">
              <div class="col-12 col-md-4">
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
              <label>Gapok Perbulan</label>
              <input type="number" name="gapok" style="font-size: 12px;" value="{{ $k->gapok }}" class="form-control" placeholder="Masukan gapok" >
            </div>

            <div class="col-12 col-md-6">
              <label>Persen</label>
              <input type="text" name="persen" style="font-size: 12px;" value="{{ $k->persen }}" class="form-control" required>
            </div>

              <div class="col-12 col-md-12">
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamat" rows="5" >{{ $k->alamat }}</textarea>
              </div>
              
              <div class="col-12">
                <label for="">Outlet</label>
                <div class="row">
                  <div class="col-4"><label for=""><input type="checkbox" id="check_all_kota" value="" name=""> All</label></div>
                  @if ($k->karyawanOfficeKota)
                    @foreach ($cabang as $kt)
                    @php
                        $nilai = 0;
                    @endphp
                        @foreach ($k->karyawanOfficeKota as $kok)
                            @if ($kok->cabang_id == $kt->id)
                            @php
                                $nilai++
                            @endphp                            
                            @endif
                        @endforeach
                        @if ($nilai)
                        <div class="col-4"><label for=""><input type="checkbox" class="kota" value="{{ $kt->id }}" name="cabang_id[]" checked> {{ preg_replace("/Kebab Yasmin/", "", $kt->nama) }}</label></div>
                        @else
                        <div class="col-4"><label for=""><input type="checkbox" class="kota" value="{{ $kt->id }}" name="cabang_id[]"> {{ preg_replace("/Kebab Yasmin/", "", $kt->nama) }}</label></div>
                        @endif             
                        
                    @endforeach
                  @else
                    @foreach ($cabang as $kt)                  
                    <div class="col-12"><label for=""><input type="checkbox" class="kota" value="{{ $kt->id }}" name="cabang_id[]"> {{ preg_replace("/Kebab Yasmin/", "", $kt->nama) }}</label></div>
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
  
