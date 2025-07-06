@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Komisi</h4>
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
        
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="komisi-tab" data-toggle="tab" href="#komisi" role="tab" aria-controls="komisi" aria-selected="true">Laporan Komisi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pengaturan-tab" data-toggle="tab" href="#pengaturan" role="tab" aria-controls="pengaturan" aria-selected="false">Pengaturan</a>
          </li>

        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="komisi" role="tabpanel" aria-labelledby="komisi-tab">
              
            <div class="row justify-content-center">
              <div class="col-12">
                  <div class="card">

                      <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#view">
                          <i class="fas fa-eye"></i> 
                          View
                        </button>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-sm" id="table">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Nama</th>
                                          <th>Jumlah Komisi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($laporan_komisi as $k)
                                      <tr>
                                      {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>Rp. {{ number_format($k->jml_komisi,2) }}</td>                              
                                      </tr>
                                    @endforeach
                                      
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          </div>

          <div class="tab-pane fade" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
            
            <div class="row justify-content-center">
              <div class="col-12">
                  <div class="card">

                      <div class="card-header">
                          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-komisi">
                              <i class="fas fa-plus-circle"></i> 
                              Tambah Komisi
                            </button>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-sm" id="table2">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Nama</th>
                                          <th>Jenis</th>
                                          <th>Type</th>
                                          <th>Jumlah</th>
                                          <th>Cek</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($komisi as $k)
                                      <tr>
                                      {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ $k->jenis }}</td>
                                        
                                          @if ($k->type == 'rp')
                                          <td>Nominal (Rp)</td>
                                          <td>Rp. {{ number_format($k->jumlah,0) }}</td>
                                          @else
                                          <td>Persentase %</td>
                                          <td>{{ number_format($k->jumlah,0) }}%</td>
                                              
                                          @endif
                                        <td>
                                          @if ($k->cek == 'Y')
                                          <i class="text-success fas fa-check-circle"></i>
                                          @else
                                          <i class="text-danger fas fa-times-circle"></i>
                                          @endif </td>
                                        <td>
                                          <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-komisi{{ $k->id }}">
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

          </div>

        </div>

        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
  <form action="{{ route('addKomisi') }}" method="post">
    @csrf
<div class="modal fade" id="add-komisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Komisi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12 col-md-8 mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan nama komisi" required>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label>Jenis</label>
                    <select class="form-control" name="jenis"  required>
                        <option value="penjualan">Produk</option>
                        <option value="invoice">Transaksi</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label>Type</label>
                    <select class="form-control" name="type"  required>
                        <option value="rp">Nominal (Rp)</option>
                        <option value="persen">Persentase %</option>
                    </select>
                </div>
                
                <div class="col-12 col-md-4">
                    <label>jumlah</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Masukan jumlah" min="1" required>
                </div>

                <div class="col-12 col-md-4">
                  <label>Status</label>
                  <select class="form-control" name="cek"  required>
                      <option value="T">OFF</option>
                      <option value="Y">ON</option>
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

@foreach ($komisi as $k)
    <!-- Modal -->
  <form action="{{ route('editKomisi') }}" method="post">
    @csrf
    @method('patch')
<div class="modal fade" id="edit-komisi{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Komisi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">
              <input type="hidden" name="id" value="{{ $k->id }}">
                <div class="col-12 col-md-8 mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan nama komisi" value="{{ $k->nama }}" required>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label>Jenis</label>
                    <select class="form-control" name="jenis"  required>
                        <option {{ $k->jenis == 'penjualan' ? 'selected' : '' }} value="penjualan">Produk</option>
                        <option {{ $k->jenis == 'invoice' ? 'selected' : '' }} value="invoice">Transaksi</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label>Type</label>
                    <select class="form-control" name="type"  required>
                        <option {{ $k->type == 'rp' ? 'selected' : '' }} value="rp">Nominal (Rp)</option>
                        <option {{ $k->type == 'persen' ? 'selected' : '' }} value="persen">Persentase %</option>
                    </select>
                </div>
                
                <div class="col-12 col-md-4">
                    <label>jumlah</label>
                    <input type="number" value="{{ $k->jumlah }}" name="jumlah" class="form-control" placeholder="Masukan jumlah" min="1" required>
                </div>

                <div class="col-12 col-md-4">
                  <label>Status</label>
                  <select class="form-control" name="cek"  required>
                      <option {{ $k->cek == 'T' ? 'selected' : '' }} value="T">OFF</option>
                      <option {{ $k->cek == 'Y' ? 'selected' : '' }} value="Y">ON</option>
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


<form action="" method="get">
  <div class="modal fade" id="view"  role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-6">
                  <label for="">
                      Dari
                  </label>
                  <input type="date" name="tgl1" class="form-control" required>
              </div>
  
              <div class="col-6">
                <label for="">
                    Sampai
                </label>
                <input type="date" name="tgl2" class="form-control" required>
            </div>
  
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="submit" name="tombol" value="batal" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan pesanan?')">Batalkan</button> --}}
          <button type="submit"  class="btn btn-primary">View</button>
        </div>
      </div>
    </div>
  </div>
  </form>

@section('script')
<script>
  $(document).ready(function() {

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
  
