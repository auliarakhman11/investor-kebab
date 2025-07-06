<div class="row">

    <div class="col-3 mb-1">
      <label for="">No Invoice</label>
    </div>

    <div class="col-3 mb-1">
        <label for="">Tanggal</label>
    </div>

    <div class="col-3 mb-1">
      <label for="">Mitra/Manager Store</label>
    </div>

    <div class="col-3 mb-1">
      <label for="">Jumlah</label>
    </div>

    <input type="hidden" name="jenis" value="{{ $jenis }}">
    <input type="hidden" name="barang_id" value="{{ $barang_id }}">

    @foreach ($dt_jurnal as $d)
    <input type="hidden" name="kd_gabungan[]" value="{{ $d->kd_gabungan }}">

    
    <div class="col-3 mb-1">
        {{ $d->kd_gabungan }}
    </div>

    <div class="col-3 mb-1">
        <input type="date"  class="form-control" name="tgl[]" value="{{ $d->tgl }}" required>
    </div>

    @if ($d->mitra_id)
    <div class="col-3 mb-1">
        <input type="hidden" name="kota_id[]" value="0">
        <select class="form-control select2bs4" name="mitra_id[]">
          @foreach ($mitra as $m)
              <option value="{{ $m->id }}" {{ $d->mitra_id == $m->id ? 'selected' : '' }}>{{ $m->nm_mitra }}</option>
          @endforeach
        </select>
    </div>
    @else
    <div class="col-3 mb-1">
        <input type="hidden" name="mitra_id[]" value="0">
        <select class="form-control select2bs4" name="kota_id[]">
          @foreach ($kota as $k)
              <option value="{{ $k->id }}" {{ $d->kota_id == $k->id ? 'selected' : '' }}>{{ $k->nm_kota }}</option>
          @endforeach
        </select>
    </div>
    @endif

    <div class="col-3 mb-1">
      <input type="number" name="qty[]" value="{{ $d->qty_kredit }}" class="form-control" required>
    </div>

    @endforeach

    

  </div>