@extends('template.master')
@section('content')

      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        {{-- <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">List Products</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row --> --}}
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
                  @endif

                  @if (session('error'))
                  <div class="alert alert-danger">
                      {{ session('error') }}
                  </div>
                  @endif --}}
                    <div class="card-header">
                        {{-- <div class="row">
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                      <select id="kota_id" class="form-control">
                                        @foreach ($kota as $cb)
                                            <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-6">
                                      <select id="bulan_tahun" class="form-control">
                                        @foreach ($bulan as $bln)
                                            <option value="{{ $bln->year }}-{{ sprintf("%02d", $bln->month)  }}">{{ date("M Y", strtotime($bln->year.'-'.$bln->month.'-01')) }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                            </div>
                        </div> --}}
                        <a href="{{ route('laporanJurnal') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th colspan="6" class="bg-primary text-light"><center>Biaya Oprasional</center></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($biaya as $d)
                              <tr>
                                <td width="15%" >{{ date("d M Y", strtotime($d->tgl)) }}</td>
                                <td width="15%" >{{ $d->akun->nm_akun }}</td>
                                <td width="20%">{{ number_format($d->debit,0) }}</td>
                                <td width="20%">{{ $d->ket }}</td>
                                <td width="20%">{{ $d->cabang ? $d->cabang->nama : '' }}</td>
                                <td width="10%"><a href="#edit{{ $d->id }}" data-toggle="modal" class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a> <a href="{{ route('deleteBiayaOprasional',$d->kd_gabungan) }}" onclick="return confirm('Apakah yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></a></td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @foreach ($biaya as $d)
  <form method="POST" action="{{ route('editBiayaOprasional') }}">
    @csrf
<div class="modal fade" id="edit{{ $d->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Biaya</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" name="kd_gabungan" value="{{ $d->kd_gabungan }}">
              
              <div class="col-12 mb-1">
                <label for="">Tanggal</label>
                <input type="date" name="tgl" class="form-control" value="{{ $d->tgl }}" required>
              </div>

              <div class="col-12 mb-1">
                <label for="">Akun</label>
                <select class="form-control" name="akun_id" required>
                  @foreach ($oprasinoal as $o)
                  <option value="{{ $o->id }}" {{ $o->id == $d->akun_id ? "selected" : ""}}>{{ $o->nm_akun }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-12 mb-1">
                <label for="">Biaya</label>
                <input type="number" name="biaya" class="form-control" value="{{ $d->debit }}" required>
              </div>

              <div class="col-12 mb-1">
                <label for="">Keterangan</label>
                <input type="text" name="ket" class="form-control" value="{{ $d->ket }}" required>
              </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_add_kasbon">Edit</button>
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
       
    
  });
</script>
@endsection
@endsection  
  
