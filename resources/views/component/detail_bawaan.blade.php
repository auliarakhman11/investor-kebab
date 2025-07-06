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
                <th class="text-center" colspan="3">Detail stok bawaan</th>
              </tr>
              <tr>
                  <th class="text-center" colspan="3">Outlet {{ $dt_buka->cabang->nama }}</th>
                </tr>
            </thead>
              <thead>
                  <tr>
                      <th >Barang</th>
                      <th >Stok Awal</th>
                      <th >Terjual</th>
                      <th >Stok Sisa</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($dt_stok as $d)
                      <tr>
                          <td>{{ $d->bahan }}</td>
                          <td>{{ $d->stok_masuk }} {{ $d->satuan }}</td>
                          <td>{{ $d->stok_masuk - $d->sisa_stok }} {{ $d->satuan }}</td>
                          <td>{{ $d->sisa_stok }} {{ $d->satuan }}</td>
                      </tr>
                  @endforeach            
              </tbody>
          </table>
    </div>
    <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
        <form id="form-edit-bawaan">
            @csrf
        <div class="row">
            @if ($dt_buka->nm_karyawan)
            <div class="col-12">
                <div class="form-group">
                    <input type="hidden" name="id_buka" value="{{ $dt_buka->id }}">
                    <label for="">Karyawan</label>
                    <input type="text" class="form-control" name="nm_karyawan" value="{{ $dt_buka->nm_karyawan }}" required>
                </div>
            </div>
            @endif

            <div class="col-11">
                <div class="form-group">
                    <label>Barang</label>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label>Aksi</label>
                </div>
            </div>

            <input type="hidden" name="kode" value="{{ $dt_buka->kode }}">
            @foreach ($dt_karyawan as $dt)
            <div class="col-12">
                <div class="form-group">
                    <input type="hidden" name="jaga_outlet_id[]" value="{{ $dt->id }}">
                    
                    <select name="karyawan_id[]" class="form-control select2bs4" required>
                        @foreach ($karyawan as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $dt->karyawan_id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach                        
                    </select>
                </div>
            </div>
            {{-- <div class="col-1">
                <div class="form-group">
                    <a href="#" stok_id="{{ $dt->id }}" class="btn btn-xs mt-2 delete-bahan btn-danger"><i class="fas fa-trash"></i></a>
                </div>
            </div> --}}
            @endforeach
            
            <div class="col-12"><hr></div>
            
            <div class="col-8">
                <div class="form-group">
                    <label>Barang</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Stok</label>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label>Aksi</label>
                </div>
            </div>            
        @foreach ($dt_edit as $d)
        
            <div class="col-8">
                <div class="form-group">
                    <input type="hidden" name="id[]" value="{{ $d->id }}">
                    <input type="hidden" name="kode" value="{{ $dt_buka->kode }}">
                    <select name="bahan_id[]" class="form-control select2bs4" required>
                        @foreach ($dt_bahan as $b)
                        <option value="{{ $b->id }}" {{ $b->id == $d->bahan_id ? 'selected' : '' }}>{{ $b->bahan }}</option>
                        @endforeach                        
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="number" class="form-control" name="debit[]" value="{{ $d->debit }}" required>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <a href="#" stok_id="{{ $d->id }}" class="btn btn-xs mt-2 delete-bahan btn-danger"><i class="fas fa-trash"></i></a>
                </div>
            </div>
       
        @endforeach
        </div>  
        <div id="form-tambah-bawaan"></div>
        <button type="submit" class="btn btn-sm btn-primary float-right ml-2">Edit/Save</button>
        <button type="button" id="btn-tambah-bawan" class="btn btn-sm btn-primary float-right">Tambah</button>
        
        </form>
    </div>
  </div>

    
    