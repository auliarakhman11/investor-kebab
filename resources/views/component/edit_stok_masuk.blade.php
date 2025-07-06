<div class="row">

    @foreach ($dt_jurnal as $d)
    <input type="hidden" name="kd_gabungan[]" value="{{ $d->kd_gabungan }}">

    <input type="hidden" name="jenis[]" value="{{ $jenis }}">

    <div class="col-3 mb-1">
        <label for="">Tanggal</label>
        <input type="date"  class="form-control" name="tgl[]" value="{{ $d->tgl }}">
    </div>

    <div class="col-3 mb-1">
      <label for="">Keterangan</label>
      <input type="text"  class="form-control" value="{{ $d->ket }}" disabled>
    </div>

    <div class="col-3 mb-1">
      <label for="">Jumlah</label>
      <input type="number" name="qty[]" value="{{ $d->qty_debit }}" class="form-control" required>
    </div>

    <div class="col-3 mb-1">
      <label for="">Total</label>
      <input type="number" value="{{ $d->debit }}" class="form-control" name="ttl_harga[]">
    </div>
    @endforeach

    

  </div>