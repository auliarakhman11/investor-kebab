<table class="table table-sm" width="100%">
    <thead>
        <tr>
            <th colspan="2" class="bg-primary text-light">
                <center>Pendapatan Bersih Oprasional</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" class="bg-info">Pendapatan</td>
        </tr>
        <tr>
            <td width="80%">Pendapatan</td>
            <td width="20%">
                <p class="text-right">{{ number_format($penjualan ? $penjualan : 0, 0) }}</p>
            </td>
        </tr>

        {{-- <tr>
            <td width="80%">Penjualan Antar Cabang</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($penjualan_cabang ? $penjualan_cabang->ttl_debit : 0, 0) }}
                </p>
            </td>
        </tr> --}}


    </tbody>
    <tbody>
        <tr>
            <td colspan="2" class="bg-info">Biaya pokok penjualan</td>
        </tr>

        @php
            $b_bahan = ($stok ? $stok : 0) + ($barang_kebutuhan ? $barang_kebutuhan : 0);

        @endphp
        <tr>
            <td width="80%">Bahan</td>
            <td width="20%">
                <p class="text-right">{{ $stok ? number_format($stok, 0) : 0 }}</p>
            </td>
        </tr>

        {{-- <tr>
          <td width="80%" >Saos</td>
          <td width="20%"><p class="text-right">
            @if ($varian)
            <a href="#modal_hpp_saos" data-toggle="modal" id="btn_hpp_saos" tgl1="{{ $tgl1 }}" tgl2="{{ $tgl2 }}" kota_id="{{ $kota_id }}">{{ number_format($varian->ttl_varian ,0) }}</a>
            @else
            0
            @endif
          </p></td>
        </tr> --}}

        <tr>
            <td width="80%">Barang Kebutuhan</td>
            <td width="20%">
                <p class="text-right">{{ $barang_kebutuhan ? number_format($barang_kebutuhan, 0) : 0 }}</p>
            </td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td colspan="2" class="bg-info">Kerugian</td>
        </tr>

        <tr>
            <td width="80%">Stok Rusak</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($rusak ? $rusak->ttl_debit : 0, 0) }}
                </p>
            </td>
        </tr>


    </tbody>
    <tbody>
        <tr>
            <td class="bg-info" colspan="2">Biaya oprasional</td>
        </tr>
        @foreach ($biaya_oprational as $d)
            @if ($d->ttl_debit)
                <tr>
                    <td width="80%">{{ $d->nm_akun }}</td>
                    <td width="20%">
                        <p class="text-right">{{ number_format($d->ttl_debit, 0) }}</p>
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td><strong>Total Biaya Oprasional</strong></td>
            <td class="text-right"><strong>{{ number_format($biaya, 0) }}</strong></td>
        </tr>
    </tbody>

    <tbody>
        <tr>
            <td class="bg-info" colspan="2">Gajih Pokok</td>
        </tr>

        <tr>
            <td width="80%">Crew</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($gapok_crew ? $gapok_crew : 0, 0) }}
                </p>
            </td>
        </tr>

    </tbody>

    <tbody>
        <tr>
            <td class="bg-info" colspan="2">Gajih Persentase</td>
        </tr>

        <tr>
            <td width="80%">Crew</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($persen_crew ? $persen_crew : 0, 0) }}
                </p>
            </td>
        </tr>

        {{-- <tr>
            <td width="80%">Office</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($persen_office ? $persen_office : 0, 0) }}
                </p>
            </td>
        </tr> --}}

        {{-- <tr>
          <td width="80%" >Investor</td>
          <td width="20%"><p class="text-right">
            {{ number_format($persen_investor,0) }}
          </p></td>
        </tr> --}}

    </tbody>

    @php
        $b_gaji = ($gapok_crew ? $gapok_crew : 0) + ($persen_crew ? $persen_crew : 0);
    @endphp

    <tbody>
        <tr>
            <td class="bg-info" colspan="2">Management Fee</td>
        </tr>
        <tr>
            <td width="80%">Management Fee</td>
            <td width="20%">
                <p class="text-right">
                    {{ number_format($persen_office + $gapok_office, 0) }}
                </p>
            </td>
        </tr>
    </tbody>



    <tbody class="bg-secondary">
        <tr>
            <td><b>Laba Bersih</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($tot_laba, 0) }}</b></p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-info">
        <tr>
            <td><b>Persen Bahan</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($b_bahan && $penjualan ? ($b_bahan * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
        <tr>
            <td><b>Persen Barang Rusak</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($rusak && $penjualan ? ($rusak->ttl_debit * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
        <tr>
            <td><b>Persen Biaya Oprasional</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($biaya && $penjualan ? ($biaya * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
        <tr>
            <td><b>Persen Gaji</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($b_gaji && $penjualan ? ($b_gaji * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>

        <tr>
            <td><b>Persen Management Fee</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($persen_office + $gapok_office && $penjualan ? (($persen_office + $gapok_office) * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>

        <tr>
            <td><b>Persen Laba Bersih</b></td>
            <td width="20%">
                <p class="text-right">
                    <b>{{ number_format($tot_laba && $penjualan ? ($tot_laba * 100) / $penjualan : 0, 2) }}%</b>
                </p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-success">
        <tr>
            <td><b>Seluruh Investor</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($tot_laba, 0) }}</b></p>
            </td>
        </tr>
    </tbody>

    <tbody class="bg-success">
        <tr>
            <td><b>Laba investor untuk anda</b></td>
            <td width="20%">
                <p class="text-right"><b>{{ number_format($investor, 0) }}</b></p>
            </td>
        </tr>
    </tbody>

</table>
