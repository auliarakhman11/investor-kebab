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
                                    <th colspan="5" class="bg-primary text-light"><center>Biaya Oprasional</center></th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $total = 0;
                              @endphp
                              @foreach ($biaya as $d)
                              @php
                                  $total += $d->ttl_debit;
                              @endphp
                              <tr>
                                <td width="25%" >{{ date("d M Y", strtotime($d->tgl)) }}</td>
                                <td width="25%" >{{ $d->akun->nm_akun }}</td>
                                {{-- <td width="20%">{{ $d->ket }}</td> --}}
                                <td width="25%">{{ $d->cabang ? $d->cabang->nama : '' }}</td>
                                <td width="25%"><p class="float-right">{{ number_format($d->ttl_debit,0) }}</p></td>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="3"><strong>Total</strong></td>
                                <td><strong class="float-right">{{ number_format($total,0) }}</strong></td>
                              </tr>
                            </tfoot>
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


  @endsection  

