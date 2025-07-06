<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kasbon as $k)
        <tr>
            <td>
                <input type="hidden" name="id[]" value="{{ $k->id }}">
                <input type="date" name="tgl[]" class="form-control" value="{{ $k->tgl }}" required>
            </td>
            <td>
                <input type="number" class="form-control" name="jumlah[]" value="{{ $k->jumlah }}" required>
            </td>
            <td>
                <button class="btn btn-xs btn-danger btn_delete" id_kasbon="{{ $k->id }}"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>