<div class="row">
    <div class="col-6 text-center">
        <label for="">Tanggal</label>
    </div>
    <div class="col-5 text-center">
        <label for="">Stok Masuk</label>
    </div>

    @foreach ($dt_stok_barang as $dsb)
    <div class="col-6 mt-2">
        <input type="hidden" name="id[]" value="{{ $dsb->id }}">
        <input type="date" class="form-control form-control-sm" name="tgl[]" value="{{ $dsb->tgl }}" required>
    </div>
    <div class="col-5 mt-2">
        <input type="number" step=".01" class="form-control form-control-sm" name="debit[]" value="{{ $dsb->debit }}" required>
    </div>
    <div class="col-1 mt-2">
        <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
    </div>
    @endforeach
    
</div>