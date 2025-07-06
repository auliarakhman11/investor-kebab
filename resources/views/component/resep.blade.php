<div class="row">

    <div class="col-6">
        <div class="form-group">
            <label >Bahan</label>
            <select name="bahan_id[]"  class="form-control select2bs4" required>
                <option value="">-Pilih Bahan-</option>
                @foreach ($bahan as $b)
                <option value="{{ $b->id }}">{{ $b->bahan }}</option>
                @endforeach                
            </select>
        </div>
    </div>

    <div class="col-5">
        <div class="form-group">
            <label>Takaran</label>
            <input type="text" name="takaran[]" class="form-control" required>
        </div>
    </div>

    <div class="col-1">
        <label>Aksi</label>
        <button type="button" id="tambah-bahan" class="btn btn-sm btn-primary">+</button>
    </div>

</div>

<div id="tambah-resep"></div>

<table class="table table-sm">
    <thead>
        <tr>
            <th rowspan="2">Bahan</th>
            <th rowspan="2">Takaran</th>
            <th rowspan="2">Aksi</th>
            <th colspan="{{ $count_kota }}" style="text-align: center;">Harga Satuan</th>
        </tr>
        <tr>
            @foreach ($kota as $k)
                <td style="font-size: 11px; text-align: center;"><b>{{ $k->nm_kota }}</b></td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($resep as $d)
        <tr>
            <td>{{ $d->bahan->bahan }}</td>
            <td>{{ $d->takaran }}</td>
            <td><a href="javascript:void(0)" produk-id = "{{ $d->produk_id }}" id-resep="{{ $d->id }}" onclick="return confirm('Apakah anda yakin ingin menghapus data resep?')" class="btn btn-xs btn-danger hapus-resep">x</a></td>
            @foreach ($kota as $index => $k)
                <td style="font-size: 11px; text-align: center;">{{ $index + 1 > count($d->hargaBahan)  ? 0 : $d->takaran * $d->hargaBahan[$index]->harga  }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<table class="table">
    <tbody>
        <tr>
            <td colspan="2"><strong>Grand Manager</strong></td>
            <td><strong>Total Harga</strong></td>
        </tr>
        @foreach ($harga as $d)
        <tr>
            <td colspan="2">{{ $d->nm_kota }}</td>
            <td>{{ number_format($d->ttl_harga,0) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


