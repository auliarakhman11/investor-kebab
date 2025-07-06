<div class="row">
    <div class="col-2"></div>
    <div class="col-8"><p  align="center" >Buka dari {{ date("d M Y H:i", strtotime($dt_buka->created_at)) }} <br> Sampai {{ date("d M Y H:i", strtotime($dt_buka->updated_at)) }}</p></div>
    <div class="col-2">
        <a href="{{ route('excelLaporanPenjualanPeroutlet',['id_buka' => $dt_buka->id])}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-file-excel"></i> Laporan</a>
    </div>
</div>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="false">Edit</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">

        <table class="table" width="100%">
            <thead>
              <tr>
                <th colspan="5">Laporan Total</th>
              </tr>
            </thead>
              <thead>
                  <tr>
                      <th >Jenis Order</th>
                      <th >Jenis Pembayaran</th>
                      <th >Jumlah Transaksi</th>
                      <th >Produk Terjual</th>
                      <th >Total Penjualan</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $total_penjualan = 0;
                  @endphp
                  @foreach ($dt_penjualan as $p)
                  @php
                      $total_penjualan += $p->ttl_penjualan;
                  @endphp
                      <tr>
                          <td>{{ $p->delivery }}</td>
                          <td>{{ $p->pembayaran }}</td>
                          <td>{{ number_format($p->jml_invoice,0) }}</td>
                          <td>{{ number_format($p->produk_terjual,0) }}</td>
                          <td>{{ number_format($p->ttl_penjualan,0) }}</td>
                      </tr>
                  @endforeach            
              </tbody>
              <tfoot>
                  <tr>
                      <th colspan="4">Total</td>
                      <th>{{ number_format($total_penjualan,0) }}</th>
                  </tr>
              </tfoot>
          </table>
          <br>
          <table class="table"  width="100%">
            <thead>
              <tr  style="margin-bottom: 2px;">
                <th colspan="4">Detail Perproduk</th>
              </tr>
            </thead>
              <thead>
                  <tr  style="margin-bottom: 2px;">
                      <th >Produk</th>
                      <th >Order</th>
                      <th >Terjual</th>
                      <th >Total</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $total_produk = 0;
                  @endphp
                  @foreach ($produk as $p)
                  @php
                      $total_produk += $p->total_terjual;
                  @endphp
                    <tr>
                      <td>{{ $p->nm_produk }}</td>
                      <td>{{ $p->delivery }}</td>
                      <td>{{ $p->qty_terjual }}</td>
                      <td>{{ number_format($p->total_terjual,0) }}</td>
                    </tr>
                    @endforeach
              </tbody>
              <tfoot>
                  <tr>
                      <th colspan="3">Total</td>
                      <th>{{ number_format($total_produk,0) }}</th>
                  </tr>
              </tfoot>
          </table>
          <br>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th class="text-center" colspan="3">Laporan stok bawaan</th>
              </tr>
            </thead>
              <thead>
                  <tr>
                      <th >Barang</th>
                      <th >Stok Awal</th>
                      <th>Terjual</th>
                      <th >Stok Sisa</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($dt_stok as $d)
                      <tr>
                          <td>{{ $d->bahan }}</td>
                          <td>{{ $d->stok_masuk }} {{ $d->satuan }}</td>
                          <td>{{ $d->stok_keluar - $d->stok_refund }} {{ $d->satuan }}</td>
                          <td>{{ $d->sisa_stok }} {{ $d->satuan }}</td>
                      </tr>
                  @endforeach            
              </tbody>
          </table>

    </div>

    <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
    <h5>Edit Barang Kebutuhan</h5>

    <form id="form-edit-kebutuhan">
        @csrf
        <input type="hidden" name="id_buka_kebutuhan" id="id_buka_kebutuhan" value="{{ $dt_buka->id }}">
    <div class="row">
        {{-- <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="id_buka" value="{{ $dt_buka->id }}">
                <label for="">Karyawan</label>
                <input type="text" class="form-control" name="nm_karyawan" value="{{ $dt_buka->nm_karyawan }}" required>
            </div>
        </div> --}}

        <div class="col-12">
            <div class="form-group">
                <label>Keterngan Tambahan</label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="text" class="form-control" name="ket_kebutuhan" value="{{ $dt_buka->ket_kebutuhan }}">
            </div>
        </div>

        <div class="col-8">
            <div class="form-group">
                <label>Barang</label>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Jumalh</label>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group">
                <label>Aksi</label>
            </div>
        </div>            
    @foreach ($kebutuhan as $d)
    
        <div class="col-8">
            <div class="form-group">
                <input type="hidden" name="id[]" value="{{ $d->id }}">
                <input type="hidden" name="kode" value="{{ $dt_buka->kode }}">
                <select name="barang_kebutuhan_id[]" class="form-control select2bs4" required>
                    @foreach ($barang_kebutuhan as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $d->barang_kebutuhan_id ? 'selected' : '' }}>{{ $b->nm_barang }}</option>
                    @endforeach                        
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <input type="number" class="form-control" name="qty[]" value="{{ $d->qty }}" required>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group">
                <a href="#" kebutuhan_id="{{ $d->id }}" class="btn btn-xs mt-2 delete-kebutuhan btn-danger"><i class="fas fa-trash"></i></a>
            </div>
        </div>
   
    @endforeach

    </div>  
    <div id="form-tambah-kebutuhan"></div>
    <button type="submit" class="btn btn-sm btn-primary float-right ml-2">Edit/Save</button>
    <button type="button" id="btn-tambah-kebutuhan" class="btn btn-sm btn-primary float-right">Tambah</button>
    
    </form>

    </div>
</div>


    