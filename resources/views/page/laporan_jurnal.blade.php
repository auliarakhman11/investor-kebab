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

                        @if (Auth::user()->role == 1)
                        <li class="nav-item">
                          <a class="nav-link" id="per_outlet-tab" data-toggle="tab" href="#per_outlet" role="tab" aria-controls="per_outlet" aria-selected="false">Per Outlet</a>
                        </li>
                        @endif
        
                        {{-- <li class="nav-item">
                          <a class="nav-link" id="neraca-tab" data-toggle="tab" href="#neraca" role="tab" aria-controls="neraca" aria-selected="false">Neraca</a>
                        </li> --}}

                        <li class="nav-item">
                          <a class="nav-link" id="stok_barang-tab" data-toggle="tab" href="#stok_barang" role="tab" aria-controls="stok_barang" aria-selected="false">Laporan Stok & Kas</a>
                        </li>
        
                      </ul>

                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="laba_rugi-tab" id="laba_rugi">
                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_laba_rugi" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_laba_rugi" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Manager Store</label>
                              <select id="kota_id_laba_rugi" class="form-control">
                                @foreach ($kota as $cb)
                                    <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                                @endforeach
                              </select>
                            </div>

                          </div>
                          <div id="laba_rugi_table"></div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="per_outlet-tab" id="per_outlet">
                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_per_outlet" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_per_outlet" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Outlet</label>
                              <select id="cabang_id_per_outlet" class="form-control">
                                @foreach ($cabang as $cb)
                                    <option value="{{ $cb->id }}">{{ $cb->nama }}</option>
                                @endforeach
                              </select>
                            </div>

                          </div>
                          <div id="per_outlet_table"></div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="neraca-tab" id="neraca">

                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_neraca" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_neraca" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Manager Store</label>
                              <select id="kota_id_neraca" class="form-control">
                                @foreach ($kota as $cb)
                                    <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                                @endforeach
                              </select>
                            </div>

                          </div>

                          <div id="neraca_table"></div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="stok_barang-tab" id="stok_barang">
                          <div class="row">

                            <div class="col-4">
                              <label for="">Dari</label>
                              <input type="date" name="tgl1" value="{{ $tgl1 }}" id="tgl1_stok_barang" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Sampai</label>
                              <input type="date" name="tgl2" value="{{ $tgl2 }}" id="tgl2_stok_barang" class="form-control">
                            </div>

                            <div class="col-4">
                              <label for="">Manager Store</label>
                              <select id="kota_id_stok_barang" class="form-control">
                                @foreach ($kota as $cb)
                                    <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                                @endforeach
                              </select>
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

    <div class="modal fade" id="modal_hpp_bahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">HPP Bahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="tabel_hpp_bahan">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_hpp_saos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">HPP Saos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="tabel_hpp_saos">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_hpp_kebutuhan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">HPP Kebutuhan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="tabel_hpp_kebutuhan">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_penjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="tabel_penjualan">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


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
                <input type="hidden" name="kota_id" id="kota_id_oprasional">
                <input type="hidden" name="tgl1" id="tgl1_oprasional">
                
                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control"  required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Outlet</label>
                  <select name="cabang_id" class="form-control select2bs4">
                    @foreach ($cabang as $cb)
                        <option value="{{ $cb->id }}">{{ $cb->nama }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12 mb-1">
                  <label for="">Akun</label>
                  <select class="form-control" name="akun_id" required>
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
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Saldo Awal Persediaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <input type="hidden" name="kota_id" id="kota_id_saldo_awal_persediaan">
                <input type="hidden" name="tgl1" id="tgl1_saldo_awal_persediaan">

                {{-- <div class="col-12 mb-1">
                  <label for="">Kas</label>
                  <input type="number" name="kas" class="form-control">
                </div> --}}

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
                  <label for="">Kas</label>
                  <input type="number" name="kas_barang[]" class="form-control">
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
                <input type="hidden" name="kota_id" id="kota_id_pembelian_barang">
                <input type="hidden" name="tgl1" id="tgl1_pembelian_barang">

                <div class="col-12 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-5 mb-1">
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

                <div class="col-3 mb-1">
                  <label for="">Total</label>
                  <input type="number" name="total[]" class="form-control" required>
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
                <input type="hidden" name="kota_id" id="kota_id_barang_rusak">
                <input type="hidden" name="tgl1" id="tgl1_barang_rusak">

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


  <form id="form_transfer_barang">
    @csrf
    <div class="modal fade" id="modal_transfer_barang" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Transfer Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <input type="hidden" name="kota_id" id="kota_id_transfer_barang">
                <input type="hidden" name="tgl1" id="tgl1_transfer_barang">

                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Manager Store</label>
                  <select name="kota_transfer" class="form-control">
                    @foreach ($kota as $cb)
                        <option value="{{ $cb->id }}">{{ $cb->nm_kota }}</option>
                    @endforeach
                  </select>
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

              <div id="tambah_transfer_barang">

              </div>
              <button type="button" id="btn_transfer_barang" class="btn btn-sm btn-primary float-right">+</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_transfer_barang">Input</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_barang_kebutuhan">
    @csrf
    <div class="modal fade" id="modal_barang_kebutuhan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Barang Kebutuhan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <input type="hidden" name="kota_id" id="kota_id_barang_kebutuhan">
                <input type="hidden" name="tgl1" id="tgl1_barang_kebutuhan">

                <div class="col-6 mb-1">
                  <label for="">Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Outlet</label>
                  <select name="cabang_id" class="form-control select2bs4">
                    @foreach ($cabang as $cb)
                        <option value="{{ $cb->id }}">{{ $cb->nama }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-6 mb-1">
                  <label for="">Barang Kebutuhan</label>
                  <select class="form-control select2bs4" name="barang_id[]" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($barang_kebutuhan as $b)
                    <option value="{{ $b->id }}">{{ $b->nm_barang }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-5 mb-1">
                  <label for="">Jumlah</label>
                  <input type="number" name="qty[]" class="form-control" required>
                </div>

              </div>

              <div id="tambah_barang_kebutuhan">

              </div>
              <button type="button" id="btn_barang_kebutuhan" class="btn btn-sm btn-primary float-right">+</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="input_barang_kebutuhan">Input</button>
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

                <div class="col-12 mb-1">
                  <label for="">Kas</label>
                  <input type="number" name="kas" id="kas_edit_saldo_awal" class="form-control">
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


    var kota_id_laba_rugi = $('#kota_id_laba_rugi').val();
    var tgl1_laba_rugi = $('#tgl1_laba_rugi').val();
    var tgl2_laba_rugi = $('#tgl2_laba_rugi').val();

    dtJurnal(kota_id_laba_rugi,tgl1_laba_rugi,tgl2_laba_rugi);


    function dtJurnal(kota_id,tgl1, tgl2){
      $('#laba_rugi_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtJurnal') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#laba_rugi_table').html(data);

                }

              });
    }

    function dtPeroutlet(cabang_id,tgl1, tgl2){
      $('#per_outlet_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtPeroutlet') }}",
                method:"GET",
                data:{cabang_id:cabang_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#per_outlet_table').html(data);

                }

              });
    }

    function getNeraca(kota_id,tgl1,tgl2){
      $('#neraca_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('getNeraca') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#neraca_table').html(data);

                }

              });
    }

    function getStokBarang(kota_id,tgl1,tgl2){
      $('#stok_barang_table').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
                url:"{{ route('dtStokBarang') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#stok_barang_table').html(data);


                }

              });
    }

    $(document).on('click', '#per_outlet-tab', function() {
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl1 = $('#tgl1_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });

    $(document).on('click', '#neraca-tab', function() {
          var kota_id = $('#kota_id_neraca').val();
          var tgl1 = $('#tgl1_neraca').val();
          var tgl2 = $('#tgl2_neraca').val();
          getNeraca(kota_id, tgl1, tgl2);
          
      });

    $(document).on('click', '#stok_barang-tab', function() {

          var kota_id = $('#kota_id_stok_barang').val();
          var tgl1 = $('#tgl1_stok_barang').val();
          var tgl2 = $('#tgl2_stok_barang').val();
          getStokBarang(kota_id, tgl1, tgl2);
          
      });

    

    $(document).on('click', '#laba_rugi-tab', function() {
          var kota_id = $('#kota_id_laba_rugi').val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnal(kota_id, tgl1, tgl2);
          
      });

    $(document).on('change', '#kota_id_laba_rugi', function() {
          var kota_id = $(this).val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnal(kota_id, tgl1, tgl2);
          
      });

      //peroutlet
      $(document).on('change', '#tgl1_per_outlet', function() {
        var tgl1 = $(this).val();
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_per_outlet', function() {
        var tgl2 = $(this).val();
          var cabang_id = $('#cabang_id_per_outlet').val();
          var tgl1 = $('#tgl1_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#cabang_id_per_outlet', function() {
          var cabang_id = $(this).val();
          var tgl1 = $('#tgl1_per_outlet').val();
          var tgl2 = $('#tgl2_per_outlet').val();
          dtPeroutlet(cabang_id, tgl1, tgl2);
          
      });
      //end peroutlet

      $(document).on('change', '#tgl1_laba_rugi', function() {
        var tgl1 = $(this).val();
          var kota_id = $('#kota_id_laba_rugi').val();
          var tgl2 = $('#tgl2_laba_rugi').val();
          dtJurnal(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_laba_rugi', function() {
        var tgl2 = $(this).val();
          var kota_id = $('#kota_id_laba_rugi').val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          dtJurnal(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#kota_id_neraca', function() {
          var kota_id = $(this).val();
          var tgl1 = $('#tgl1_neraca').val();
          var tgl2 = $('#tgl2_neraca').val();
          getNeraca(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl1_neraca', function() {
        var tgl1 = $(this).val();
          var kota_id = $('#kota_id_neraca').val();
          var tgl2 = $('#tgl2_neraca').val();
          getNeraca(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_neraca', function() {
        var tgl2 = $(this).val();
          var kota_id = $('#kota_id_neraca').val();
          var tgl1 = $('#tgl1_neraca').val();
          getNeraca(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#kota_id_stok_barang', function() {
          var kota_id = $(this).val();
          var tgl1 = $('#tgl1_stok_barang').val();
          var tgl2 = $('#tgl2_stok_barang').val();
          getStokBarang(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl1_stok_barang', function() {
        var tgl1 = $(this).val();
          var kota_id = $('#kota_id_stok_barang').val();
          var tgl2 = $('#tgl2_stok_barang').val();
          getStokBarang(kota_id, tgl1, tgl2);
          
      });

      $(document).on('change', '#tgl2_stok_barang', function() {
        var tgl2 = $(this).val();
          var kota_id = $('#kota_id_stok_barang').val();
          var tgl1 = $('#tgl1_stok_barang').val();
          getStokBarang(kota_id, tgl1, tgl2);
          
      });

      $(document).on('click', '.btn_biaya', function() {
          var kota_id =  $('#kota_id_laba_rugi').val();
          var tgl1 = $('#tgl1_laba_rugi').val();
          
          $('#kota_id_oprasional').val(kota_id);
          $('#tgl1_oprasional').val(tgl1);
          
      });

      $(document).on('submit', '#form_oprasional', function(event){  
           event.preventDefault();
            $('#input_oprasional').attr('disabled',true);
            $('#input_oprasional').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
            $.ajax({  
                     url:"{{ route('addBiayaOprasional') }}",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                        $('#modal_biaya').modal('hide');
                        $('#form_input_pengeluaran').trigger("reset");
                        $("#input_oprasional").removeAttr("disabled");
                        $('#input_oprasional').html('Input'); //tombol simpan

                        var kota_id = $('#kota_id_laba_rugi').val();
                        var tgl1 = $('#tgl1_laba_rugi').val();
                        var tgl2 = $('#tgl2_laba_rugi').val();

                        dtJurnal(kota_id,tgl1,tgl2);
                     }  ,
                        error: function (err) { //jika error tampilkan error pada console
                          console.log(err);
                          $("#input_oprasional").removeAttr("disabled");
                          $('#input_oprasional').html('Input'); //tombol simpan
                        }
                }); 

            });

      
            var count_saldo_persediaan = 1;
            $(document).on('click', '#btn_saldo_persediaan', function() {
              count_saldo_persediaan = count_saldo_persediaan + 1;
              var html_code = '<div class="row" id="row'+count_saldo_persediaan+'">';

              html_code += '<div class="col-4 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-3 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-4 mb-1"><input type="number" name="kas_barang[]" class="form-control"></div>';

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
                var kota_id =  $('#kota_id_stok_barang').val();
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#kota_id_saldo_awal_persediaan').val(kota_id);
                $('#tgl1_saldo_awal_persediaan').val(tgl1);

                $('#tambah_saldo_awal_persediaan').html('');
                
            });


            $(document).on('submit', '#form_saldo_awal_persediaan', function(event){  
            event.preventDefault();
              $('#input_saldo_awal_persediaan').attr('disabled',true);
              $('#input_saldo_awal_persediaan').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('saldoAwalPersediaan') }}",  
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

                          var kota_id = $('#kota_id_stok_barang').val();
                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarang(kota_id, tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_saldo_awal_persediaan").removeAttr("disabled");
                            $('#input_saldo_awal_persediaan').html('Input'); //tombol simpan
                          }
                  }); 

              });

              //pembelian barang

              var count_pembelian_barang = 1;
            $(document).on('click', '#btn_pembelian_barang', function() {
              count_pembelian_barang = count_pembelian_barang + 1;
              var html_code = '<div class="row" id="row'+count_pembelian_barang+'">';

              html_code += '<div class="col-5 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-3 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';
              
              html_code += '<div class="col-3 mb-1"><input type="number" name="total[]" class="form-control" required></div>';
              
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
                var kota_id =  $('#kota_id_stok_barang').val();
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#kota_id_pembelian_barang').val(kota_id);
                $('#tgl1_pembelian_barang').val(tgl1);

                $('#tambah_pembelian_barang').html('');
                
            });


            $(document).on('submit', '#form_pembelian_barang', function(event){  
            event.preventDefault();
              $('#input_pembelian_barang').attr('disabled',true);
              $('#input_pembelian_barang').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('pembelianBarang') }}",  
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

                          var kota_id = $('#kota_id_stok_barang').val();
                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarang(kota_id, tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_pembelian_barang").removeAttr("disabled");
                            $('#input_pembelian_barang').html('Input'); //tombol simpan
                          }
                  }); 

              });
       //end pembelian barang

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

            $(document).on('click', '#btn_modal_barang_rusak', function() {
                var kota_id =  $('#kota_id_stok_barang').val();
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#kota_id_barang_rusak').val(kota_id);
                $('#tgl1_barang_rusak').val(tgl1);

                $('#tambah_barang_rusak').html('');
                
            });


            $(document).on('submit', '#form_barang_rusak', function(event){  
            event.preventDefault();
              $('#input_barang_rusak').attr('disabled',true);
              $('#input_barang_rusak').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('barangRusak') }}",  
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

                          var kota_id = $('#kota_id_stok_barang').val();
                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarang(kota_id, tgl1, tgl2);
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_barang_rusak").removeAttr("disabled");
                            $('#input_barang_rusak').html('Input'); //tombol simpan
                          }
                  }); 

              });
       //end barang rusak


       //transfer barang

       var count_transfer_barang = 1;
            $(document).on('click', '#btn_transfer_barang', function() {
              count_transfer_barang = count_transfer_barang + 1;
              var html_code = '<div class="row" id="row'+count_transfer_barang+'">';

              html_code += '<div class="col-6 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($bahan as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($varian as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach @foreach ($barang as $b)<option value="{{ $b->barang_id }}|{{ $b->jenis }}">{{ $b->nama }} ({{ $b->nm_jenis }})</option>@endforeach</select></div>';

              html_code += '<div class="col-5 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_transfer_barang + '" class="btn btn-danger btn-sm remove_transfer_barang">-</button></div>';

              html_code += "</div>";

              $('#tambah_transfer_barang').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_transfer_barang', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_modal_transfer_barang', function() {
                var kota_id =  $('#kota_id_stok_barang').val();
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#kota_id_transfer_barang').val(kota_id);
                $('#tgl1_transfer_barang').val(tgl1);

                $('#tambah_transfer_barang').html('');
                
            });


            $(document).on('submit', '#form_transfer_barang', function(event){  
            event.preventDefault();
              $('#input_transfer_barang').attr('disabled',true);
              $('#input_transfer_barang').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('transferBarang') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          if(data){
                            $('#modal_transfer_barang').modal('hide');
                            $('#form_transfer_barang').trigger("reset");
                            $("#input_transfer_barang").removeAttr("disabled");
                            $('#input_transfer_barang').html('Input'); //tombol simpan

                            var kota_id = $('#kota_id_stok_barang').val();
                          var tgl1 = $('#tgl1_stok_barang').val();
                          var tgl2 = $('#tgl2_stok_barang').val();

                          getStokBarang(kota_id, tgl1, tgl2);
                          }else{
                            Swal.fire({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 3000,
                              icon: 'error',
                              title: 'Kota harus beda'
                            });

                            $("#input_transfer_barang").removeAttr("disabled");
                            $('#input_transfer_barang').html('Input'); //tombol simpan
                          }
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_transfer_barang").removeAttr("disabled");
                            $('#input_transfer_barang').html('Input'); //tombol simpan
                          }
                  }); 

              });
       //end transfer barang

       //barang kebutuhan

       var count_barang_kebutuhan = 1;
            $(document).on('click', '#btn_barang_kebutuhan', function() {
              count_barang_kebutuhan = count_barang_kebutuhan + 1;
              var html_code = '<div class="row" id="row'+count_barang_kebutuhan+'">';

              html_code += '<div class="col-6 mb-1"><select class="form-control select2bs4" name="barang_id[]" required><option value="">Pilih Barang</option>@foreach ($barang_kebutuhan as $b)<option value="{{ $b->id }}">{{ $b->nm_barang }}</option>@endforeach</select></div>';

              html_code += '<div class="col-5 mb-1"><input type="number" name="qty[]" class="form-control" required></div>';

              html_code += '<div class="col-1"><button type="button" data-row="row' + count_barang_kebutuhan + '" class="btn btn-danger btn-sm remove_barang_kebutuhan">-</button></div>';

              html_code += "</div>";

              $('#tambah_barang_kebutuhan').append(html_code);
              $('.select2bs4').select2({
                              theme: 'bootstrap4',
                              tags: true,
                          });
            });

            $(document).on('click', '.remove_barang_kebutuhan', function() {
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });

            $(document).on('click', '#btn_modal_barang_kebutuhan', function() {
                var kota_id =  $('#kota_id_stok_barang').val();
                var tgl1 = $('#tgl1_stok_barang').val();
                
                $('#kota_id_barang_kebutuhan').val(kota_id);
                $('#tgl1_barang_kebutuhan').val(tgl1);

                $('#tambah_barang_kebutuhan').html('');
                
            });


            $(document).on('submit', '#form_barang_kebutuhan', function(event){  
            event.preventDefault();
              $('#input_barang_kebutuhan').attr('disabled',true);
              $('#input_barang_kebutuhan').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('jurnalBarangKebutuhan') }}",  
                      method:'POST',  
                      data:new FormData(this),  
                      contentType:false,  
                      processData:false,  
                      success:function(data)  
                      {  
                          if(data){
                            $('#modal_barang_kebutuhan').modal('hide');
                            $('#form_barang_kebutuhan').trigger("reset");
                            $("#input_barang_kebutuhan").removeAttr("disabled");
                            $('#input_barang_kebutuhan').html('Input'); //tombol simpan

                            var kota_id = $('#kota_id_stok_barang').val();
                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarang(kota_id, tgl1, tgl2);
                          }else{
                            Swal.fire({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 3000,
                              icon: 'error',
                              title: 'Kota harus beda'
                            });

                            $("#input_barang_kebutuhan").removeAttr("disabled");
                            $('#input_barang_kebutuhan').html('Input'); //tombol simpan
                          }
                      }  ,
                          error: function (err) { //jika error tampilkan error pada console
                            console.log(err);
                            $("#input_barang_kebutuhan").removeAttr("disabled");
                            $('#input_barang_kebutuhan').html('Input'); //tombol simpan
                          }
                  }); 

              });
       //end barang kebutuhan

       $(document).on('click', '#btn_hpp_bahan', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          
          $('#tabel_hpp_bahan').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
          $.ajax({
                url:"{{ route('getHppBahan') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#tabel_hpp_bahan').html(data);

                }

              });
          
      });

      $(document).on('click', '#btn_hpp_saos', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          
          $('#tabel_hpp_saos').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
          $.ajax({
                url:"{{ route('getHppSaos') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#tabel_hpp_saos').html(data);

                }

              });
          
      });

      $(document).on('click', '#btn_hpp_kebutuhan', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          
          $('#tabel_hpp_kebutuhan').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
          $.ajax({
                url:"{{ route('getHppKebutuhan') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#tabel_hpp_kebutuhan').html(data);

                }

              });
          
      });

      $(document).on('click', '#btn_penjualan', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          
          $('#tabel_penjualan').html('Loading... <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
          $.ajax({
                url:"{{ route('getDtPenjualan') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2},
                success:function(data){
                  $('#tabel_penjualan').html(data);

                }

              });
          
      });

      

      $(document).on('click', '.edit_saldo_awal', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          var id_barang = $(this).attr('id_barang');
          var jenis = $(this).attr('jenis');
          
          $.ajax({
                url:"{{ route('getSaldoAwal') }}",
                method:"GET",
                dataType:"JSON",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
                success:function(data){
                  $('#kd_gabungan_edit_saldo_awal').val(data.kd_gabungan);
                  $('#nm_barang_edit_saldo_awal').val(data.nama_barang);
                  $('#qty_edit_saldo_awal').val(data.qty_debit);

                  $('#kas_edit_saldo_awal').val(data.kas);

                  $('#jenis_edit_saldo_awal').val(jenis);

                }

              });
          
      });

      $(document).on('submit', '#form_edit_saldo_awal', function(event){  
            event.preventDefault();
              $('#edit_saldo_awal').attr('disabled',true);
              $('#edit_saldo_awal').html('Loading <div class="ld"><div></div><div></div><div></div></div>');
              $.ajax({  
                      url:"{{ route('editSaldoAwal') }}",  
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

                            var kota_id = $('#kota_id_stok_barang').val();
                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarang(kota_id, tgl1, tgl2);
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

        $(document).on('click', '.edit_stok_masuk', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          var id_barang = $(this).attr('id_barang');
          var jenis = $(this).attr('jenis');
          
          $.ajax({
                url:"{{ route('getStokMasuk') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
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
                      url:"{{ route('editStokMasuk') }}",  
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

                            var kota_id = $('#kota_id_stok_barang').val();
                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarang(kota_id, tgl1, tgl2);
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

      $(document).on('click', '.edit_stok_rusak', function() {
          var kota_id = $(this).attr('kota_id');
          var tgl1 = $(this).attr('tgl1');
          var tgl2 = $(this).attr('tgl2');
          var id_barang = $(this).attr('id_barang');
          var jenis = $(this).attr('jenis');
          
          $.ajax({
                url:"{{ route('getStokRusak') }}",
                method:"GET",
                data:{kota_id:kota_id, tgl1:tgl1, tgl2:tgl2, id_barang:id_barang, jenis:jenis,},
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
                      url:"{{ route('editStokRusak') }}",  
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

                            var kota_id = $('#kota_id_stok_barang').val();
                            var tgl1 = $('#tgl1_stok_barang').val();
                            var tgl2 = $('#tgl2_stok_barang').val();

                            getStokBarang(kota_id, tgl1, tgl2);
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
    
  });
</script>
@endsection
@endsection  
  
