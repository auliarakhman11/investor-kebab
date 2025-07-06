<table class="table table-sm" width="100%">
    <thead>
        <tr>
            <th colspan="2" class="bg-primary text-light">
                <center>Pendapatan Bersih Operasional</center>
            </th>
        </tr>
    </thead>

    <tbody class="bg-info">
        <tr>
            <td colspan="2">Pendapatan</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Pendapatan</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_penjualan, 0) }}</p>
            </td>
        </tr>
        <tr>
            <td>Penjualan Antar Cabang</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_penjualan_antar_cabang, 0) }}</p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-info">
        <tr>
            <td colspan="2">Biaya Pokok Penjualan</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Bahan</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_bahan, 0) }}</p>
            </td>
        </tr>
        <tr>
            <td>Saos</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_varian, 0) }}</p>
            </td>
        </tr>
        <tr>
            <td>Barang Kebutuhan</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_kebutuhan, 0) }}</p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-info">
        <tr>
            <td colspan="2">Kebutuhan</td>
        </tr>
    </tbody>
    <tbody>
        @foreach ($biaya_oprational as $d)
            <tr>
                <td>{{ $d->nm_akun }}</>
                </td>
                <td width="20%">
                    <p class="text-right">{{ number_format($d->ttl_debit, 0) }}</p>
                </td>
            </tr>
        @endforeach

    </tbody>

    <tbody class="bg-info">
        <tr>
            <td colspan="2">Gajih</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Crew</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_gapok_crew, 0) }}</p>
            </td>
        </tr>
        <tr>
            <td>Office</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_gapok_office, 0) }}</p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-info">
        <tr>
            <td colspan="2">Persen</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Crew</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_persen_crew, 0) }}</p>
            </td>
        </tr>
        <tr>
            <td>Office</td>
            <td width="20%">
                <p class="text-right">{{ number_format($sum_persen_office, 0) }}</p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-primary">
        <tr>
            <td colspan="2">
                <center>Investore</center>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><b>Laba Bersih</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($sum_laba, 0) }}</b></p>
            </td>
        </tr>
        <tr>
        <tr>
            <td><b>Persen Bahan</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($sum_penjualan && $sum_bahan ? ($sum_bahan * 100) / $sum_penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
        <tr>
            <td><b>Persen Biaya Oprational</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($sum_penjualan && $sum_biaya ? ($sum_biaya * 100) / $sum_penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
        <tr>
            <td><b>Persen Gaji</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($sum_penjualan && $sum_gaji ? ($sum_gaji * 100) / $sum_penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>

        <tr>
            <td><b>Persen Laba</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($sum_penjualan && $sum_laba ? ($sum_laba * 100) / $sum_penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>

        <tr class="bg-success">
            <td><b>Persen Investor</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($sum_laba && $sum_investor ? ($sum_investor * 100) / $sum_laba : 0, 2) }}%</b></p>
            </td>
        </tr>

        <tr class="bg-success">
            <td><b>Investor</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($sum_investor, 0) }}</b></p>
            </td>
        </tr>

        <tr>
            <td><b>Persen Management Fee</b></td>
            <td width="20%">
                <p class="text-right"><b>10%</b></p>
            </td>
        </tr>

        <tr>
            <td><b>Management Fee</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($sum_laba ? ($sum_laba * 10) / 100 : 0, 0) }}</b></p>
            </td>
        </tr>
    </tbody>


    {{-- <tbody class="bg-info">
        <tr>
          <td><b>Laba Bersih</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_laba,0) }}</b></p></td>
        </tr>
        <tr>
          <td><b>Persen Bahan</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format( $sum_penjualan && $sum_bahan ? $sum_bahan * 100 / $sum_penjualan  : 0,2) }}%</b></p></td>
        </tr>
        <tr>
          <td><b>Persen Biaya Oprational</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format( $sum_penjualan && $sum_biaya ?  $sum_biaya * 100 / $sum_penjualan : 0,2) }}%</b></p></td>
        </tr>
        <tr>
          <td><b>Persen Gaji</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_penjualan && $sum_gaji ? $sum_gaji * 100 / $sum_penjualan : 0,2) }}%</b></p></td>
        </tr>

        <tr>
          <td><b>Persen Laba</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_penjualan && $sum_laba ? $sum_laba * 100 / $sum_penjualan : 0,2) }}%</b></p></td>
        </tr>

        <tr class="bg-success">
          <td><b>Persen Investor</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_laba && $sum_investor ? $sum_investor * 100 / $sum_laba : 0,2) }}%</b></p></td>
        </tr>

        <tr class="bg-success">
          <td><b>Investor</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_investor,0) }}</b></p></td>
        </tr>

        <tr>
          <td><b>Persen Management Fee</b></td>
          <td width="20%"><p class="text-right"><b>10%</b></p></td>
        </tr>

        <tr>
          <td><b>Management Fee</b></td>
          <td width="20%"><p class="text-right"><b>{{ number_format($sum_laba ? $sum_laba * 10 / 100 : 0,0) }}</b></p></td>
        </tr>
      </tbody> --}}


</table>
