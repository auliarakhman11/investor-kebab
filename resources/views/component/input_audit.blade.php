
@php
    $dt_audit = [];
    foreach($data_audit as $dau){
        $dt_audit [] = $dau->list_id;
    }
@endphp

<input type="hidden" name="buka_toko_id" value="{{ $buka_toko_id }}">
<input type="hidden" name="tanggal" value="{{ $tanggal }}">
<input type="hidden" name="karyawan_id" value="{{ $karyawan_id }}">
<input type="hidden" name="cabang_id" value="{{ $cabang_id }}">

<table class="table table-sm">
    <tbody>
      @foreach ($jenis_audit as $ja)
      <tr>
        <td colspan="2"><strong>{{ $ja->nm_jenis }}</strong></td>
      </tr>
      @if ($ja->listAudit)
      @foreach ($ja->listAudit as $l)
          <tr>
            <td>{{ $l->nm_audit }}</td>
            <td>
              <input class="form-control" name="list_id[]" type="checkbox" {{ in_array($l->id, $dt_audit) ? 'checked' : '' }} value="{{ $l->id }}">
            </td>
          </tr>
      @endforeach
      @endif
      
      @endforeach
      
    </tbody>
  </table>