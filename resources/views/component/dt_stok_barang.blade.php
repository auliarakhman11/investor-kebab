<div class="row">
    <div class="col-12">
      @if (Auth::user()->role == 1)
        <a href="#modal_saldo_awal_persediaan" id="btn_saldo_awal_persediaan" class="btn btn-sm btn-primary float-right mt-2 mb-2 ml-2" data-toggle="modal">Saldo Awal Persediaan</a>
      @endif  
        <a href="#modal_pembelian_barang" id="btn_modal_pembelian_barang" class="btn btn-sm btn-primary float-right mt-2 mb-2 ml-2" data-toggle="modal"><i class="fas fa-truck-loading"></i> Pembelian Barang</a>
        <a href="#modal_barang_rusak" id="btn_modal_barang_rusak" class="btn btn-sm btn-primary float-right mt-2 mb-2 ml-2" data-toggle="modal"><i class="fas fa-skull"></i> Barang Rusak</a>
        <a href="#modal_transfer_barang" id="btn_modal_transfer_barang" class="btn btn-sm btn-primary float-right mt-2 mb-2 ml-2" data-toggle="modal"><i class="fas fa-exchange-alt"></i> Transfer Barang</a>

        <a href="#modal_barang_kebutuhan" id="btn_modal_barang_kebutuhan" class="btn btn-sm btn-primary float-right mt-2 mb-2 ml-2" data-toggle="modal"><i class="fas fa-box-open"></i> Barang Kebutuhan</a>
        
      </div>
      <div class="col-12">
        <table class="table table-sm" width="100%">
            <thead>
                <tr>
                    <th colspan="9" class="bg-primary text-light"><center>Saldo Barang</center></th>
                </tr>
            </thead>
            <tbody>
              <tr class="bg-info">
                <td>Barang</td>
                <td>Stok Awal</td>
                <td>Stok Masuk</td>
                <td>Stok Rusak</td>
                <td>Stok Keluar</td>
                <td>Stok Update</td>
                <td>Stok Baku</td>
                <td>Stok Order</td>
                <th>Kas Update</th>
              </tr>
              @foreach ($dt_bahan as $d)
              @php
                  $cek = $d->saldo_awal + $d->pembelian + $d->pembelian2 + $d->rusak + ($d->ttl_kredit - $d->ttl_debit) + $d->penjualan2;
              @endphp
              @if ($cek)
              <tr>
                <td>
                  {{ $d->bahan }}
                </td>
                <td>
                  @if ($d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_saldo_awal" class="edit_saldo_awal" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="1" data-toggle="modal">{{ $d->saldo_awal }}</a>
                  @else
                  {{ $d->saldo_awal }}
                  @endif
                </td>
                <td>
                  @if (($d->pembelian + $d->pembelian2) && $d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_stok_masuk" class="edit_stok_masuk" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="1" data-toggle="modal">{{ ($d->pembelian + $d->pembelian2) }}</a>
                  @else
                  {{ $d->pembelian + $d->pembelian2 }}
                  @endif
                </td>
                <td>
                  @if ($d->rusak)
                  <a href="#modal_edit_stok_rusak" class="edit_stok_rusak" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="1" data-toggle="modal">{{ $d->rusak }}</a>
                  @else
                  {{ $d->rusak }}
                  @endif
                </td>
                <td>{{ ($d->ttl_kredit - $d->ttl_debit) + $d->penjualan2 + $d->penjualan11 }}</td>
                <td>{{ ($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + ($d->ttl_kredit - $d->ttl_debit) + $d->penjualan2 + $d->penjualan11) }}</td>
                <td>{{ $d->stok_baku }}</td>

                <td>{{ $d->stok_baku - (($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + ($d->ttl_kredit - $d->ttl_debit) + $d->penjualan2 + $d->penjualan11)) }}</td>
                <td>{{ number_format($d->kas + $d->pendapatan + ($d->pendapatan2 - $d->pendapatan3) - $d->pengeluaran,0) }}</td>
              </tr>
              @endif
              
              @endforeach
              @foreach ($dt_varian as $d)
              @php
                  $cek = $d->saldo_awal + $d->pembelian + $d->pembelian2 + $d->rusak + $d->qty_varian + $d->penjualan2;
              @endphp
              @if ($cek)
              <tr>
                <td>{{ $d->nm_varian }}</td>
                <td>
                  @if ($d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_saldo_awal" class="edit_saldo_awal" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="2" data-toggle="modal">{{ $d->saldo_awal }}</a>
                  @else
                  {{ $d->saldo_awal }}
                  @endif
                </td>
                <td>
                  @if (($d->pembelian + $d->pembelian2) && $d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_stok_masuk" class="edit_stok_masuk" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="2" data-toggle="modal">{{ ($d->pembelian + $d->pembelian2) }}</a>
                  @else
                  {{ $d->pembelian + $d->pembelian2 }}
                  @endif
                </td>
                <td>
                  @if ($d->rusak)
                  <a href="#modal_edit_stok_rusak" class="edit_stok_rusak" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="2" data-toggle="modal">{{ $d->rusak }}</a>
                  @else
                  {{ $d->rusak }}
                  @endif
                </td>
                <td>{{ $d->qty_varian + $d->penjualan2 + $d->penjualan11 }}</td>
                <td>{{ ($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + $d->qty_varian + $d->penjualan2 + $d->penjualan11) }}</td>
                <td>{{ $d->stok_baku }}</td>
                <td>{{ $d->stok_baku - (($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + $d->qty_varian + $d->penjualan2 + $d->penjualan11)) }}</td>
                <td>{{ number_format($d->kas + $d->pendapatan + $d->pendapatan2 - $d->pengeluaran,0) }}</td>
              </tr>
              @endif
              @endforeach
              @foreach ($dt_kebutuhan as $d)
              <tr>
                <td>{{ $d->nama }}</td>
                <td>
                  @if ($d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_saldo_awal" class="edit_saldo_awal" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="3" data-toggle="modal">{{ $d->saldo_awal }}</a>
                  @else
                  {{ $d->saldo_awal }}
                  @endif
                </td>
                <td>
                  @if (($d->pembelian + $d->pembelian2) && $d->saldo_awal && Auth::user()->role == 1)
                  <a href="#modal_edit_stok_masuk" class="edit_stok_masuk" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="3" data-toggle="modal">{{ ($d->pembelian + $d->pembelian2) }}</a>
                  @else
                  {{ $d->pembelian + $d->pembelian2 }}
                  @endif
                </td>
                <td>
                  @if ($d->rusak)
                  <a href="#modal_edit_stok_rusak" class="edit_stok_rusak" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}" id_barang="{{ $d->id }}" jenis="3" data-toggle="modal">{{ $d->rusak }}</a>
                  @else
                  {{ $d->rusak }}
                  @endif
                </td>
                <td>{{ $d->penjualan + $d->penjualan2 + $d->penjualan11 }}</td>
                <td>{{ ($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + $d->penjualan + $d->penjualan2 + $d->penjualan11) }}</td>
                <td>{{ $d->stok_baku }}</td>
                <td>{{ $d->stok_baku - (($d->saldo_awal + $d->pembelian + $d->pembelian2) - ($d->rusak + $d->penjualan + $d->penjualan2 + $d->penjualan11)) }}</td>
                <td>{{ number_format($d->kas + $d->pendapatan - $d->pengeluaran,0) }}</td>
              </tr>
              @endforeach
            </tbody>
            
        </table>
      </div>
</div>
