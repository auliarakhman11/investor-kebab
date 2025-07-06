@extends('template.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Penjualan Online</h4>
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
                        <button type="button" class="btn btn-primary btn-sm float-right ml-2" data-toggle="modal" data-target="#view">
                            <i class="fas fa-eye"></i> 
                            View
                          </button>

                          <button type="button" class="btn btn-primary btn-sm float-right" onclick="startFCM()">
                            <i class="fas fa-eye"></i> 
                            Get Token
                          </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Waktu</th>
                                        <th>Costumer</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Outlet</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i=1;
                                  @endphp
                                  @foreach ($invoice as $inv)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ date("d M Y H:i", strtotime($inv->created_at)); }}</td>
                                      <td>{{ $inv->costumer->nama }}</td>
                                      <td>{{ $inv->no_tlp }}</td>
                                      <td>{{ $inv->alamat }}</td>
                                      <td>{{ $inv->cabang ? $inv->cabang->nama : '-' }}</td>
                                      <td class="{{ $inv->status == 'Selesai' ? 'text-success' : ($inv->status == 'Diproses' ? 'text-primary' : ($inv->status == 'Tertolak' ? 'text-danger' : ($inv->status == 'Dimasak' ? 'text-warning' : ''))) }}">{{ $inv->status }}</td>
                                      <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#view{{ $inv->id }}">
                                        <i class="fas fa-search"></i>
                                      </button>

                                      <form action="{{ route('selesaiPenjol') }}" method="post" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="id_inv" value="{{ $inv->id }}">
                                        <button type="submit" class="btn btn-xs btn-success" onclick="return confirm('Apakah anda yakin ingin menyelesaikan pesanan?')" {{ $inv->cabang_id == 0 || $inv->status == 'Tertolak' || $inv->status == 'Selesai' ? 'disabled' : '' }}>
                                          <i class="fas fa-check-circle"></i> 
                                        </button>
                                      </form>

                                    <form action="{{ route('voidPenjol') }}" method="post" class="d-inline-block">
                                      @csrf
                                      <input type="hidden" name="id_inv" value="{{ $inv->id }}">
                                      <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan pesanan?')" {{ $inv->status == 'Selesai' ? 'disabled' : '' }}>
                                        <i class="fas fa-times-circle"></i> 
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
@foreach ($invoice as $inv)
<form action="{{ route('aksiPenjol') }}" method="post">
    @csrf
    <input type="hidden" name="no_invoice" value="{{ $inv->no_invoice }}">
<div class="modal fade" id="view{{ $inv->id }}"  role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inv->penjualan as $pnj)
                    {{-- @php
                        dd($pnj->getMenu->nm_produk)
                    @endphp --}}
                    <tr>
                        <td>{{ $pnj->getMenu->nm_produk }}
                        @if ($pnj->penjualanVarian)
                            @foreach ($pnj->penjualanVarian as $pv)
                                <br>
                                {{ $pv->varian->nm_varian }}
                            @endforeach
                        @endif

                        @if ($pnj->ket)
                            <br>
                            <i>*{{ $pnj->ket }}</i>
                        @endif
                        </td>
                        <td>{{ $pnj->qty }}
                          @if ($pnj->penjualanVarian)
                              @foreach ($pnj->penjualanVarian as $pv)
                                  <br>
                                  {{ $pv->qty }}
                              @endforeach
                          @endif
                        </td>
                        <td>
                          Rp. {{ number_format($pnj->harga,0) }}
                          @if ($pnj->penjualanVarian)
                              @foreach ($pnj->penjualanVarian as $pv)
                                  <br>
                                  Rp. {{ number_format($pv->harga,0) }}
                              @endforeach
                          @endif
                        </td>
                        <td>Rp. {{ number_format($pnj->total,0) }}</td>
                    </tr>

                    
                    @endforeach
                    <tr>
                    <td colspan="3" class="text-center"><strong>Total</strong></td>
                    <td><strong>Rp. {{ number_format($inv->total,0) }}</strong></td>  
                    </tr>                    
                </tbody>
            </table>
            <div class="row">
              <div class="col-5 mb-2">
                  <label for="">
                      <dt>Outlet</dt>
                  </label>
                  <select name="cabang_id" class="form-control select2bs4" required>
                    <option value="" {{ $inv->cabang_id == 0 ? 'selected' : '' }}>-Pilih Outlet-</option>
                    @foreach ($outlet as $o)
                    <option value="{{ $o->id }}" {{ $inv->cabang_id == $o->id ? 'selected' : '' }} >{{ $o->nama }}</option> 
                    @endforeach
                  </select>
              </div>

              <div class="col-7">
                <label >Alamat</label>
                <p>{{ $inv->alamat }}</p>
              </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="submit" name="tombol" value="batal" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan pesanan?')">Batalkan</button> --}}
          @if ($inv->latitude && $inv->longitude)
          <a href="https://www.google.com/maps/search/?api=1&query={{ $inv->latitude }},{{ $inv->longitude }}" target="_blank" class="btn btn-primary"><i class="fas fa-map-marked"></i> Maps</a>
          @endif
          @php
              $nomor = substr($inv->no_tlp,1);
          @endphp

          <a href="https://wa.me/+62{{ $nomor }}" target="_blank" class="btn btn-primary"><i class="fab fa-whatsapp"></i> Hubungi Pembeli</a>

          @if ($inv->cabang_id != 0 && $inv->cabang)

          @if ($inv->cabang->no_tlpn)
          @php
              $no_wa = substr($inv->cabang->no_tlpn,1);
          @endphp
          <a href="https://wa.me/+62{{ $no_wa }}" target="_blank" class="btn btn-primary"><i class="fab fa-whatsapp"></i> Hubungi Outlet</a>
          @endif
              
          @endif
          
          
          @if ($inv->status == 'Diproses')
          <button type="submit" name="tombol" value="selesai" class="btn btn-primary">Selesai</button>
          @endif
          
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
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
  var firebaseConfig = {
      apiKey: 'AIzaSyDfJZenxqaiz1yjIEx7_OEhjh_BYNIOH9E',
  authDomain: 'push-notification-96a8f.firebaseapp.com',
  databaseURL: 'https://project-id.firebaseio.com',
  projectId: 'push-notification-96a8f',
  storageBucket: 'push-notification-96a8f.appspot.com',
  messagingSenderId: '179871800285',
  appId: '1:179871800285:web:1ecd5308100043cfbeb434',
  measurementId: 'G-measurement-id',
  };
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
  function startFCM() {
      messaging
          .requestPermission()
          .then(function () {
              return messaging.getToken()
          })
          .then(function (response) {
              // $.ajaxSetup({
              //     headers: {
              //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              //     }
              // });
              $.ajax({
                  url: '{{ route("store.token") }}',
                  type: 'POST',
                  data: {
                      token: response
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      alert('Token stored.');
                  },
                  error: function (error) {
                      alert(error);
                      console.log(error);
                  },
              });
          }).catch(function (error) {
              alert(error);
              console.log(error);
          });
  }
  messaging.onMessage(function (payload) {
      const title = payload.notification.title;
      const options = {
          body: payload.notification.body,
          icon: payload.notification.icon,
      };
      new Notification(title, options);
  });
</script>

<script>
  $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
</script>

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
  
