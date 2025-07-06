<style>
    .th-atas {
			position: -webkit-sticky; /* Safari */
      position: sticky;
      top:0;
		}
</style>

<div class="table-responsive">
    @php
        $i=1;
    @endphp
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="th-atas">#</th>
          <th class="th-atas">Tanggal</th>
          <th class="th-atas">Outlet</th>
          <th class="th-atas">Status</th>
          <th class="th-atas">Karyawan</th>
          <th class="th-atas">Buka</th>
          <th class="th-atas">Tutup</th>
          <th class="th-atas">Lihat</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach ($dt_detail_buka as $d)
        @php
            if(date("H:i:s", strtotime($d->jam_buka)) < '12:00:00'){
              if(date("H:i:s", strtotime($d->jam_buka)) > '08:00:00'){
                $telat = 1;
              }else {
                $telat = 0;
              }
            }else{
              if(date("H:i:s", strtotime($d->jam_buka)) > '17:00:00'){
                $telat = 1;
              }else {
                $telat = 0;
              }
            }
        @endphp
        <tr>
          <td>{{ $i++ }}</td>
          <td>{{ date("d M Y", strtotime($d->tgl_last)) }}</td>
          <td>{{ $d->nama }}</td>
          <td>
          @if ($d->waktu_tutup)
          <span class="text-primary">Tutup</span><br>
          <button type="button" class="btn btn-xs btn-warning buka-toko" kode = "{{ $d->kode }}">
            Buka Toko
          </button>
          @else
          <span class="text-danger">Buka</span>
          @endif
          </td>
          <td>{{ $d->nm_karyawan ? $d->nm_karyawan : $d->nama_karyawan }}</td>
          <td class="{{ $telat ? 'text-danger text-bold' : '' }}">{{ date("H:i:s", strtotime($d->jam_buka)) }}</td>
          <td>{{ $d->waktu_tutup ? date("H:i:s", strtotime($d->waktu_tutup)) : '-' }}</td>
          <td class="text-center">
            @if ($d->waktu_tutup)
            <button type="button" class="btn btn-xs btn-primary detail-buka" id_buka = "{{ $d->id_buka }}" data-toggle="modal" data-target="#detail-buka">
              <i class="fas fa-search"></i>
            </button>

            <button type="button" class="btn btn-xs btn-danger refund-invoice" kode = "{{ $d->kode }}" data-toggle="modal" data-target="#refund-invoice">
              Refund
            </button>
            @else
            <button type="button" class="btn btn-xs btn-primary detail-bawaan" id_buka = "{{ $d->id_buka }}" data-toggle="modal" data-target="#detail-bawaan">
              <i class="fas fa-box-open"></i>
            </button>
            
            @endif                                
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>