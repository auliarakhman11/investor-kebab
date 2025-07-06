<style>
    .th-atas {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top:0;
		}
</style>

<div class="table-responsive">
    <table class="table table-sm" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Karyawan</th>
                <th>Jumlah Kasbon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
          @php
              $i=1;
          @endphp
          @foreach ($kasbon as $br)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $br->karyawan->nama }}</td>
              <td>{{ number_format($br->total,0) }}</td>
              <td>
                <button type="button" class="btn btn-xs btn-primary btn_edit" data-toggle="modal" data-target="#edit-kasbon" karyawan_id="{{ $br->karyawan_id }}">
                  <i class="fas fa-edit"></i> 
                </button>
              </td>
            </tr>
          @endforeach
            
        </tbody>
    </table>
  </div>