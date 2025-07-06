<table class="table">
    <thead>
        <tr>
            <th>Karyawan</th>
            <th>Outlet</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jaga as $j)
        <tr>
            <td>{{ $j->karyawan->nama }}</td>
            <td>{{ preg_replace("/Kebab Yasmin/","", $j->cabang->nama) }}</td>
            <td>{{ $j->role == 1 ? 'Leader' : ($j->role == 2 ? 'Rolling' : 'MS' ) }}</td>
            <td>
                @if ($j->jml_audit)
                <button data-toggle="modal" buka_toko_id="{{ $j->buka_toko_id }}" data-target="#modal_audit" karyawan_id="{{ $j->karyawan_id }}" cabang_id="{{ $j->cabang_id }}" class="btn btn-xs btn-success btn_audit"><i class="fas fa-check-circle"></i></button>
                @else
                <button data-toggle="modal" buka_toko_id="{{ $j->buka_toko_id }}" data-target="#modal_audit" karyawan_id="{{ $j->karyawan_id }}" cabang_id="{{ $j->cabang_id }}" class="btn btn-xs btn-primary btn_audit"><i class="fas fa-edit"></i></button>
                @endif
            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>