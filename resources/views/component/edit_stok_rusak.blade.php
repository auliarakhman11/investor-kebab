<div class="row">

    @foreach ($dt_jurnal as $d)
    <input type="hidden" name="kd_gabungan[]" value="{{ $d->kd_gabungan }}">

    <input type="hidden" name="jenis[]" value="{{ $jenis }}">

    <div class="col-4 mb-1">
        <label for="">Tanggal</label>
        <input type="date"  class="form-control" name="tgl[]" value="{{ $d->tgl }}">
    </div>

    <div class="col-4 mb-1">
      <label for="">Jumlah</label>
      <input type="number" name="qty[]" value="{{ $d->qty_kredit }}" class="form-control" required>
    </div>

    <div class="col-4 mb-1">
      <label for="">Total</label>
      <input type="number" value="{{ $d->kredit }}" class="form-control" disabled>
    </div>
    @endforeach


  </div>