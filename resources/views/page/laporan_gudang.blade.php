@extends('template.master')
@section('content')

@php
  $tgl1 = date('Y-m-01');
  $tgl2 = date('Y-m-t');
@endphp

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
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                          <a class="nav-link active" id="laba_rugi-tab" data-toggle="tab" href="#laba_rugi" role="tab" aria-controls="laba_rugi" aria-selected="true">Laba Rugi</a>
                        </li>

        
                        {{-- <li class="nav-item">
                          <a class="nav-link" id="neraca-tab" data-toggle="tab" href="#neraca" role="tab" aria-controls="neraca" aria-selected="false">Neraca</a>
                        </li> --}}

                        <li class="nav-item">
                          <a class="nav-link" id="stok_barang-tab" data-toggle="tab" href="#stok_barang" role="tab" aria-controls="stok_barang" aria-selected="false">Stok Barang</a>
                        </li>
        
                      </ul>

                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="laba_rugi-tab" id="laba_rugi">
                          <div class="row">

                            <div class="col-4">
                              
                            </div>

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_laba_rugi" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_laba_rugi" class="form-control">
                            </div>

                            

                          </div>
                          <div id="laba_rugi_table"></div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="stok_barang-tab" id="stok_barang">
                          <div class="row">

                            <div class="col-4">
                              
                            </div>

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_stok_barang" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_stok_barang" class="form-control">
                            </div>

                            

                          </div>

                        <div id="stok_barang_table"></div>
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

  <form id="form_oprasional">
    @csrf
    <div class="modal fade" id="modal_biaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Biaya Oprasional</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                
                <div class="col-12 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control"  required>
                </div>

                <div class="col-12 mb-1">
                  <label for="">Akun</label>
                  <select class="form-control select2bs4" name="akun_id" required>
                    <option value="">Pilih Akun</option>
                    @foreach ($oprasinoal as $o)
                    <option value="{{ $o->id }}">{{ $o->nm_akun }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12 mb-1">
                  <label for="">Biaya</label>
                  <input type="number" name="biaya" class="form-control"  required>
                </div>

                <div class="col-12 mb-1">
                  <label for="">Keterangan</label>
                  <input type="text" name="ket" class="form-control"  required>
                </div>

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_oprasional">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_saldo_awal_persediaan">
    @csrf
    <div class="modal fade" id="modal_saldo_awal_persediaan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Saldo Awal Persediaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <input type="hidden" name="tgl1" id="tgl1_saldo_awal_persediaan">

                {{-- <div class="col-12 mb-1">
                  <label for="">Kas</label>
                  <input type="number" name="kas" class="form-control">
                </div> --}}

                <div class="col-6 mb-1">
                  <label for="">Barang</label>
                  <select class="form-control select2bs4" name="barang_id[]" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($bahan as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($varian as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($barang as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-5 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" class="form-control" required>
                </div>

              </div>

              <div id="tambah_saldo_awal_persediaan">

              </div>
              <button type="button" id="btn_saldo_persediaan" class="btn btn-sm btn-primary float-right">+</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_saldo_awal_persediaan">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_barang_rusak">
    @csrf
    <div class="modal fade" id="modal_barang_rusak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Barang Rusak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">

                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Keterangan</label>
                  <input type="text" name="ket" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Barang</label>
                  <select class="form-control select2bs4" name="barang_id[]" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($bahan as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($varian as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($barang as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-5 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" class="form-control" required>
                </div>

              </div>

              <div id="tambah_barang_rusak">

              </div>
              <button type="button" id="btn_barang_rusak" class="btn btn-sm btn-primary float-right">+</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_barang_rusak">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_pembelian_barang">
    @csrf
    <div class="modal fade" id="modal_pembelian_barang" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Pembelian Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">

                <div class="col-12 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Barang</label>
                  <select class="form-control select2bs4" name="barang_id[]" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($bahan as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($varian as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($barang as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-3 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" class="form-control" required>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Total Harga</label>
                  <input type="number" name="ttl_harga[]" class="form-control" required>
                </div>

              </div>

              <div id="tambah_pembelian_barang">

              </div>
              <button type="button" id="btn_pembelian_barang" class="btn btn-sm btn-primary float-right">+</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_pembelian_barang">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <form id="form_penjualan_barang">
    @csrf
    <div class="modal fade" id="modal_penjualan_barang" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Penjualan Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Manager Store</label>
                  <select class="form-control select2bs4" name="kota_id" id="kota_id" required>
                    <option value="">Pilih Manager Store</option>
                    @foreach ($kota as $k)
                    <option value="{{ $k->id }}">{{ $k->nm_kota }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Barang</label>
                  <select class="form-control select2bs4 barang barang1" urutan="1" name="barang_id[]" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($bahan as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($varian as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($barang as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-3 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" class="form-control qty qty1" urutan="1" required>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Harga</label>
                  <input type="number" class="form-control harga_beli harga_beli1" urutan="1" readonly required>
                </div>

              </div>

              <div id="tambah_penjualan_barang">

              </div>
              <button type="button" id="btn_penjualan_barang" class="btn btn-sm btn-primary float-right">+</button>

              <div class="row">
                <div class="col-8"></div>
                <div class="col-4 mb-1">
                  <label for="">Total Harga</label>
                  <input type="number" id="tot_harga_kota" class="form-control" readonly required>
                </div>
              </div>

            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_penjualan_barang">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_penjualan_barang_mitra">
    @csrf
    <div class="modal fade" id="modal_penjualan_barang_mitra" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Penjualan Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Mitra</label>
                  <select class="form-control select2bs4" name="mitra_id" id="mitra_id" required>
                    <option value="">Pilih Mitra</option>
                    @foreach ($mitra as $m)
                    <option value="{{ $m->id }}">{{ $m->nm_mitra }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Barang</label>
                  <select class="form-control select2bs4 barang_mitra barang_mitra1" name="barang_id[]" urutan="1" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($bahan as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($varian as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                    @foreach ($barang as $b)
                    <option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-3 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" urutan="1" class="form-control qty_mitra qty_mitra1" required>
                </div>

                <div class="col-4 mb-1">
                  <label for="">Harga</label>
                  <input type="number" name="harga_beli[]" class="form-control harga_beli_mitra harga_beli_mitra1" readonly required>
                </div>

                

              </div>

              <div id="tambah_penjualan_barang_mitra">

              </div>
              <button type="button" id="btn_penjualan_barang_mitra" class="btn btn-sm btn-primary float-right">+</button>
              
              <div class="row">
                <div class="col-8"></div>
                <div class="col-4 mb-1">
                  <label for="">Total Harga</label>
                  <input type="number" id="tot_harga" class="form-control" readonly required>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_penjualan_barang">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_edit_saldo_awal">
    @csrf
    <div class="modal fade" id="modal_edit_saldo_awal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Edit Saldo Awal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">

                <input type="hidden" name="kd_gabungan" id="kd_gabungan_edit_saldo_awal">

                <input type="hidden" name="jenis" id="jenis_edit_saldo_awal">
                <div class="col-12 mb-1">
                  <label for="">Nama Barang</label>
                  <input type="text" id="nm_barang_edit_saldo_awal" class="form-control" disabled>
                </div>

                <div class="col-12 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty" id="qty_edit_saldo_awal" class="form-control" required>
                </div>

              </div>


              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_saldo_awal">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <form id="form_edit_stok_masuk">
    @csrf
    <div class="modal fade" id="modal_edit_stok_masuk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Edit Stok Masuk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="table_edit_stok_masuk">
              


              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_stok_masuk">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_edit_stok_rusak">
    @csrf
    <div class="modal fade" id="modal_edit_stok_rusak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Edit Stok Rusak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="table_edit_stok_rusak">
              


              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_stok_rusak">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <form id="form_edit_stok_keluar">
    @csrf
    <div class="modal fade" id="modal_edit_stok_keluar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Edit Penjualan Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="table_edit_stok_keluar">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_edit_stok_keluar">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="modal fade" id="modal_history_penjualan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="exampleModalLabel">History Penjulan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="penjualan_perinv">

        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_edit_stok_keluar">Edit</button>
        </div> --}}
      </div>
    </div>
  </div>

  

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


    var tgl1_laba_rugi = $('#tgl1_laba_rugi').val();
    var tgl2_laba_rugi = $('#tgl2_laba_rugi').val();

    dtJurnalGudang(tgl1_laba_rugi,tgl2_laba_rugi);
    
    function dtJurnalGudang(tgl1, tgl2){
      $('#laba_rugi_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtJurnalGudang') }}",
                method:"GET",
                data:{tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#laba_rugi_table').html(data);

                }

              });
    }

    $(document).on('click', '#laba_rugi-tab', function() {
          var tgl1 = $('#tgl1_laba_rugi').val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnalGudang(tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl1_laba_rugi', function() {
        var tgl1 = $(this).val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnalGudang(tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_laba_rugi', function() {
        var tgl2 = $(this).val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          dtJurnalGudang(tgl1, tgl2);
          
      });

      $(document).on('submit', '#form_oprasional', function(event){  
           event.preventDefault();
            $('#input_oprasional').attr('disabled',true);
            $('#input_oprasional').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
            $.ajax({  
                     url:"{{ route('addBiayaOprasionalGudang') }}",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                        $('#modal_biaya').modal('hide');
                        $('#form_oprasional').trigger("reset");
                        $("#input_oprasional").removeAttr("disabled");
                        $('#input_oprasional').html('Input'); //tombol simpan

                        var tgl1 = $('#tgl1_laba_rugi').val();
                        var tgl2 = $('#tgl2_laba_rugi').val();

                        dtJurnalGudang(tgl1, tgl2);
                     }  ,
                        error: function (err) { //jika error tampilkan error pada console
                          console.log(err);
                          $("#input_oprasional").removeAttr("disabled");
                          $('#input_oprasional').html('Input'); //tombol simpan
                        }
                }); 

            });

            function getStokBarangGudang(tgl1,tgl2){
            $('#stok_barang_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
            $.ajax({
                      url:"{{ route('dtStokBarangGudang') }}",
                      method:"GET",
                      data:{tgl1:tgl1, tgl2:tgl2},
                      success:function(data){
                        $('#stok_barang_table').html(data);


                      }

                    });
          }

          $(document).on('click', '#stok_barang-tab', function() {

          var tgl1 = $('#tgl1_stok_barang').val();
          var tgl2 = $('#tgl2_stok_barang').val();
          getStokBarangGudang(tgl1, tgl2);

          });

          $(document).on('change', '#tgl1_stok_barang', function() {
            var tgl1 = $(this).val();
              var tgl2 = $('#tgl2_stok_barang').val();
              getStokBarangGudang(tgl1, tgl2);
              
          });

          $(document).on('change', '#tgl2_stok_barang', function() {
            var tgl2 = $(this).val();
              var tgl1 = $('#tgl1_stok_barang').val();
              getStokBarangGudang(tgl1, tgl2);
              
          });

          //saldo awal
          var count_saldo_persediaan = 1;
            $(document).on('click', '#btn_saldo_persediaan', function() {
              count_saldo_persediaan = count_saldo_persediaan + 1;
              var html_code = '<div class="row" id="row'+count_saldo_persediaan+'">';

              html_code += '<div class="col-6 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-5 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_saldo_persediaan + '" class="btn btn-danger btn-sm remove_saldo_persediaan">-</button></div>';

              html_code += "</div>";

              $('#tambah_saldo_awal_persediaan').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_saldo_persediaan', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_saldo_awal_persediaan', function() {
                
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#tgl1_saldo_awal_persediaan').val(tgl1);

                $('#tambah_saldo_awal_persediaan').html('');
                
            });

            $(document).on('submit', '#form_saldo_awal_persediaan', function(event){  
            event.preventDefault();
              $('#input_saldo_awal_persediaan').attr('disabled',true);
              $('#input_saldo_awal_persediaan').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('saldoAwalPersediaanGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_saldo_awal_persediaan').modal('hide');
                          $('#form_saldo_awal_persediaan').trigger("reset");
                          $("#input_saldo_awal_persediaan").removeAttr("disabled");
                          $('#input_saldo_awal_persediaan').html('Input'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_saldo_awal_persediaan").removeAttr("disabled");
                            $('#input_saldo_awal_persediaan').html('Input'); //tombol simpan
                          }
                  }); 

              });

              $(document).on('click', '.edit_saldo_awal', function() {
                  var tgl1 = $(this).attr('tgl1');
                  var tgl2 = $(this).attr('tgl2');
                  var id_barang = $(this).attr('id_barang');
                  var jenis = $(this).attr('jenis');
                  
                  $.ajax({
                        url:"{{ route('getSaldoAwalGudang') }}",
                        method:"GET",
                        dataType:"JSON",
                        data:{tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
                        success:function(data){
                          $('#kd_gabungan_edit_saldo_awal').val(data.kd_gabungan);
                          $('#nm_barang_edit_saldo_awal').val(data.nama_barang);
                          $('#qty_edit_saldo_awal').val(data.qty_debit);

                          $('#jenis_edit_saldo_awal').val(jenis);

                        }

                      });
                  
              });

              $(document).on('submit', '#form_edit_saldo_awal', function(event){  
            event.preventDefault();
              $('#edit_saldo_awal').attr('disabled',true);
              $('#edit_saldo_awal').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('editSaldoAwalGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          if(data){
                            $('#modal_edit_saldo_awal').modal('hide');
                            $('#form_edit_saldo_awal').trigger("reset");
                            $("#edit_saldo_awal").removeAttr("disabled");
                            $('#edit_saldo_awal').html('Edit'); //tombol simpan

                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarangGudang(tgl1, tgl2);
                          }else{
                            Swal.fire({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 3000,
                              icon: 'error',
                              title: 'Kota harus beda'
                            });

                            $("#edit_saldo_awal").removeAttr("disabled");
                            $('#edit_saldo_awal').html('Edit'); //tombol simpan
                          }
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#edit_saldo_awal").removeAttr("disabled");
                            $('#edit_saldo_awal').html('Edit'); //tombol simpan
                          }
                  }); 

              });

              //end saldo awal

              //barang rusak

            var count_barang_rusak = 1;
            $(document).on('click', '#btn_barang_rusak', function() {
              count_barang_rusak = count_barang_rusak + 1;
              var html_code = '<div class="row" id="row'+count_barang_rusak+'">';

              html_code += '<div class="col-6 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-5 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_barang_rusak + '" class="btn btn-danger btn-sm remove_barang_rusak">-</button></div>';

              html_code += "</div>";

              $('#tambah_barang_rusak').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_barang_rusak', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });


            $(document).on('submit', '#form_barang_rusak', function(event){  
            event.preventDefault();
              $('#input_barang_rusak').attr('disabled',true);
              $('#input_barang_rusak').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('barangRusakGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_barang_rusak').modal('hide');
                          $('#form_barang_rusak').trigger("reset");
                          $("#input_barang_rusak").removeAttr("disabled");
                          $('#input_barang_rusak').html('Input'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_barang_rusak").removeAttr("disabled");
                            $('#input_barang_rusak').html('Input'); //tombol simpan
                          }
                  }); 

              });

              $(document).on('click', '#btn_modal_barang_rusak', function() {

                $('#tambah_barang_rusak').html('');
                
            });

            $(document).on('click', '.edit_stok_rusak', function() {
              var tgl1 = $(this).attr('tgl1');
              var tgl2 = $(this).attr('tgl2');
              var id_barang = $(this).attr('id_barang');
              var jenis = $(this).attr('jenis');
              
              $.ajax({
                    url:"{{ route('getStokRusakGudang') }}",
                    method:"GET",
                    data:{tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
                    success:function(data){
                      $('#table_edit_stok_rusak').html(data);

                    }

                  });
              
          });


          $(document).on('submit', '#form_edit_stok_rusak', function(event){  
                event.preventDefault();
                  $('#edit_stok_rusak').attr('disabled',true);
                  $('#edit_stok_rusak').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
                  $.ajax({  
                          url:"{{ route('editStokRusakGudang') }}",  
                          method:'POST',  
                          data:new FormData(this),  
                          contentType:false,  
                          processData:false,  
                          success:function(data)  
                          {  
                              if(data){
                                $('#modal_edit_stok_rusak').modal('hide');
                                $('#form_edit_stok_rusak').trigger("reset");
                                $("#edit_stok_rusak").removeAttr("disabled");
                                $('#edit_stok_rusak').html('Edit'); //tombol simpan

                                var tgl1 = $('#tgl1_stok_barang').val();
                                var tgl2 = $('#tgl2_stok_barang').val();

                                getStokBarangGudang(tgl1, tgl2);
                              }else{
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  showConfirmButton: false,
                                  timer: 3000,
                                  icon: 'error',
                                  title: 'Kota harus beda'
                                });

                                $("#edit_stok_rusak").removeAttr("disabled");
                                $('#edit_stok_rusak').html('Edit'); //tombol simpan
                              }
                          }  ,
                              error: function (err) { //jika error tampilkan error pada console
                                console.log(err);
                                $("#edit_stok_rusak").removeAttr("disabled");
                                $('#edit_stok_rusak').html('Edit'); //tombol simpan
                              }
                      }); 

                  });
       //end barang rusak

       //pembelian barang

       var count_pembelian_barang = 1;
            $(document).on('click', '#btn_pembelian_barang', function() {
              count_pembelian_barang = count_pembelian_barang + 1;
              var html_code = '<div class="row" id="row'+count_pembelian_barang+'">';

              html_code += '<div class="col-4 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-3 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-4 mb-1"><input type="number" name="ttl_harga[]" class="form-control" required></div>';
              
              html_code += '<div class="col-1"><button type="button" data-row="row' + count_pembelian_barang + '" class="btn btn-danger btn-sm remove_pembelian_barang">-</button></div>';

              html_code += "</div>";

              $('#tambah_pembelian_barang').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_pembelian_barang', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_modal_pembelian_barang', function() {

                $('#tambah_pembelian_barang').html('');
                
            });


            $(document).on('submit', '#form_pembelian_barang', function(event){  
            event.preventDefault();
              $('#input_pembelian_barang').attr('disabled',true);
              $('#input_pembelian_barang').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('pembelianBarangGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_pembelian_barang').modal('hide');
                          $('#form_pembelian_barang').trigger("reset");
                          $("#input_pembelian_barang").removeAttr("disabled");
                          $('#input_pembelian_barang').html('Input'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_pembelian_barang").removeAttr("disabled");
                            $('#input_pembelian_barang').html('Input'); //tombol simpan
                          }
                  }); 

              });

            $(document).on('click', '.edit_stok_masuk', function() {
                var tgl1 = $(this).attr('tgl1');
                var tgl2 = $(this).attr('tgl2');
                var id_barang = $(this).attr('id_barang');
                var jenis = $(this).attr('jenis');
                
                $.ajax({
                      url:"{{ route('getStokMasukGudang') }}",
                      method:"GET",
                      data:{tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
                      success:function(data){
                        $('#table_edit_stok_masuk').html(data);

                      }

                    });
                
            });


            $(document).on('submit', '#form_edit_stok_masuk', function(event){  
            event.preventDefault();
              $('#edit_stok_masuk').attr('disabled',true);
              $('#edit_stok_masuk').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('editStokMasukGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          if(data){
                            $('#modal_edit_stok_masuk').modal('hide');
                            $('#form_edit_stok_masuk').trigger("reset");
                            $("#edit_stok_masuk").removeAttr("disabled");
                            $('#edit_stok_masuk').html('Edit'); //tombol simpan

                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarangGudang(tgl1, tgl2);
                          }else{
                            Swal.fire({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 3000,
                              icon: 'error',
                              title: 'Kota harus beda'
                            });

                            $("#edit_stok_masuk").removeAttr("disabled");
                            $('#edit_stok_masuk').html('Edit'); //tombol simpan
                          }
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#edit_stok_masuk").removeAttr("disabled");
                            $('#edit_stok_masuk').html('Edit'); //tombol simpan
                          }
                  }); 

              });
       //end pembelian barang

       //penjualan barang

       var count_penjualan_barang = 1;
            $(document).on('click', '#btn_penjualan_barang', function() {
              count_penjualan_barang = count_penjualan_barang + 1;
              var html_code = '<div class="row" id="row'+count_penjualan_barang+'">';

              html_code += '<div class="col-4 mb-1"><select class="form-control select2bs4 barang barang'+count_penjualan_barang+'" urutan="'+count_penjualan_barang+'" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-3 mb-1"><input type="number" name="qty[]" class="form-control qty qty'+count_penjualan_barang+'" urutan="'+count_penjualan_barang+'" required></div>';

              html_code += '<div class="col-4 mb-1"><input type="number" class="form-control harga_beli harga_beli'+count_penjualan_barang+'" readonly required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_penjualan_barang + '" class="btn btn-danger btn-sm remove_penjualan_barang">-</button></div>';

              html_code += "</div>";

              $('#tambah_penjualan_barang').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_penjualan_barang', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_modal_penjualan_barang', function() {

              $('#tambah_penjualan_barang').html('');

            });


            $(document).on('submit', '#form_penjualan_barang', function(event){  
            event.preventDefault();
              $('#input_penjualan_barang').attr('disabled',true);
              $('#input_penjualan_barang').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('PenjualanBarangGudang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_penjualan_barang').modal('hide');
                          $('#form_penjualan_barang').trigger("reset");
                          $("#input_penjualan_barang").removeAttr("disabled");
                          $('#input_penjualan_barang').html('Input'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);

                          window.location.href = "print-invoice/"+data;
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_penjualan_barang").removeAttr("disabled");
                            $('#input_penjualan_barang').html('Input'); //tombol simpan
                          }
                  }); 

              });

       //end penjualan barang

       //penjualan barang mitra

       var count_penjualan_barang_mitra = 1;
            $(document).on('click', '#btn_penjualan_barang_mitra', function() {
              count_penjualan_barang_mitra = count_penjualan_barang_mitra + 1;
              var html_code = '<div class="row" id="row'+count_penjualan_barang_mitra+'">';

              html_code += '<div class="col-4 mb-1"><select class="form-control select2bs4 barang_mitra barang_mitra'+count_penjualan_barang_mitra+'" urutan="'+count_penjualan_barang_mitra+'" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-3 mb-1"><input type="number" name="qty[]" class="form-control qty_mitra qty_mitra'+count_penjualan_barang_mitra+'" urutan="'+count_penjualan_barang_mitra+'" required></div>';

              html_code += '<div class="col-4 mb-1"><input type="number" name="harga_beli[]" class="form-control harga_beli_mitra harga_beli_mitra'+count_penjualan_barang_mitra+'" readonly required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_penjualan_barang_mitra + '" class="btn btn-danger btn-sm remove_penjualan_barang_mitra">-</button></div>';

              html_code += "</div>";

              $('#tambah_penjualan_barang_mitra').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_penjualan_barang_mitra', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_modal_penjualan_barang_mitra', function() {

              $('#tambah_penjualan_barang_mitra').html('');

            });


            $(document).on('submit', '#form_penjualan_barang_mitra', function(event){  
            event.preventDefault();
              $('#input_penjualan_barang_mitra').attr('disabled',true);
              $('#input_penjualan_barang_mitra').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('penjualanBarangMitra') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_penjualan_barang_mitra').modal('hide');
                          $('#form_penjualan_barang_mitra').trigger("reset");
                          $("#input_penjualan_barang_mitra").removeAttr("disabled");
                          $('#input_penjualan_barang_mitra').html('Input'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);

                          window.location.href = "print-invoice/"+data;
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_penjualan_barang_mitra").removeAttr("disabled");
                            $('#input_penjualan_barang_mitra').html('Input'); //tombol simpan
                          }
                  }); 

              });

       //end penjualan barang

       //hitung mitra
       function getHargaMitra(mitra_id,barang_mitra,qty,urutan){
        $.ajax({
                url:"{{ route('getHargaMitra') }}",
                method:"GET",
                data:{mitra_id:mitra_id, barang_mitra:barang_mitra},
                success:function(data){
                  var harga_beli = data * qty;
                  $('.harga_beli_mitra'+urutan).val(harga_beli);

                  var tot_harga = 0;

                $(".harga_beli_mitra").each(function() {
                  
                  tot_harga += parseInt($(this).val());

                  });

                  $('#tot_harga').val(tot_harga);

                }

              });

                
       }

       $(document).on('change', '.barang_mitra', function() {

        var urutan = $(this).attr('urutan');
        var barang_mitra = $(this).val();
        var qty = $('.qty_mitra'+urutan).val();
        var mitra_id = $('#mitra_id').val();


        getHargaMitra(mitra_id,barang_mitra,qty,urutan);

      });

      $(document).on('keyup', '.qty_mitra', function() {

      var urutan = $(this).attr('urutan');
      var barang_mitra = $('.barang_mitra'+urutan).val();
      var qty = $(this).val();
      var mitra_id = $('#mitra_id').val();

      getHargaMitra(mitra_id,barang_mitra,qty,urutan);

      });

      //end hitung mitra

      //hitung manager store
      function getHargaKota(kota_id,barang,qty,urutan){
        $.ajax({
                url:"{{ route('getHargaKota') }}",
                method:"GET",
                data:{kota_id:kota_id, barang:barang},
                success:function(data){
                  var harga_beli = data * qty;
                  $('.harga_beli'+urutan).val(harga_beli);

                  var tot_harga = 0;

                $(".harga_beli").each(function() {
                  
                  tot_harga += parseInt($(this).val());

                  });

                  $('#tot_harga_kota').val(tot_harga);

                }

              });

                
       }

       $(document).on('change', '.barang', function() {

        var urutan = $(this).attr('urutan');
        var barang = $(this).val();
        var qty = $('.qty'+urutan).val();
        var kota_id = $('#kota_id').val();


        getHargaKota(kota_id,barang,qty,urutan);

      });

      $(document).on('keyup', '.qty', function() {

      var urutan = $(this).attr('urutan');
      var barang = $('.barang'+urutan).val();
      var qty = $(this).val();
      var kota_id = $('#kota_id').val();

      getHargaKota(kota_id,barang,qty,urutan);

      });

      //end hitung manager store


      $(document).on('click', '.edit_stok_keluar', function() {
                var tgl1 = $(this).attr('tgl1');
                var tgl2 = $(this).attr('tgl2');
                var id_barang = $(this).attr('id_barang');
                var jenis = $(this).attr('jenis');
                
                $.ajax({
                      url:"{{ route('getStokKeluarGudang') }}",
                      method:"GET",
                      data:{tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
                      success:function(data){
                        $('#table_edit_stok_keluar').html(data);

                        $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });

                      }

                    });
                
            });

            $(document).on('submit', '#form_edit_stok_keluar', function(event){  
            event.preventDefault();
              $('#btn_edit_stok_keluar').attr('disabled',true);
              $('#btn_edit_stok_keluar').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('editStokKeluarMitra') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          $('#modal_edit_stok_keluar').modal('hide');
                          $('#form_edit_stok_keluar').trigger("reset");
                          $("#btn_edit_stok_keluar").removeAttr("disabled");
                          $('#btn_edit_stok_keluar').html('Edit'); //tombol simpan

                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarangGudang(tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#btn_edit_stok_keluar").removeAttr("disabled");
                            $('#btn_edit_stok_keluar').html('Edit'); //tombol simpan
                          }
                  }); 

              });

              function getHistoryPerinv(tgl1,tgl2){
                $('#penjualan_perinv').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
                $.ajax({
                          url:"{{ route('getHistoryPerinv') }}",
                          method:"GET",
                          data:{tgl1:tgl1, tgl2:tgl2},
                          success:function(data){
                            $('#penjualan_perinv').html(data);


                          }

                        });
              }

              $(document).on('click', '#btn_modal_history_penjualan', function() {

              var tgl1 = $('#tgl1_stok_barang').val();
              var tgl2 = $('#tgl2_stok_barang').val();
              getHistoryPerinv(tgl1, tgl2);

              });


  });
</script>
@endsection
@endsection  
  
