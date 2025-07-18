<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css" media="all" />

    <style>
        .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{asset('img')}}/kebabyasmin.jpeg">
      </div>
      <h1>INVOICE {{ $dt_jurnal[0]->kd_inv }}</h1>
      <div id="company" class="clearfix">
        <div>Kebab Yasmin</div>
        <div>081349433414</div>
        <div>kebabyasminofficial@gmail.com</div>
        <div></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Invoice Penjualan</div>
        @if ($dt_jurnal[0]->mitra_id)
        <div><span>MITRA</span> {{ $dt_jurnal[0]->mitra->nm_mitra }}</div>
        @else
        <div><span>STORE</span> {{ $dt_jurnal[0]->kota->nm_kota }}</div>
        @endif
        <div><span>DATE</span> {{ date("d M Y", strtotime($dt_jurnal[0]->tgl)) }}</div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="desc">BARANG</th>
            <th>HARGA</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
            @php
                $gtotal = 0;
            @endphp
            @foreach ($dt_jurnal as $j)
            <tr>
                @if ($j->bahan_id)
                <td class="desc">{{ $j->bahan->bahan }}</td>
                @elseif ($j->varian_id)
                <td class="desc">{{ $j->varian->nm_varian }}</td>
                @else
                <td class="desc">{{ $j->kebutuhan->nm_barang }}</td>
                @endif
                <td class="unit">{{ number_format($j->debit/$j->qty_debit,0) }}</td>
                <td class="qty">{{ $j->qty_debit }}</td>
                <td class="total">{{ number_format($j->debit,0) }}</td>
            </tr>
            @php
                $gtotal += $j->debit;
            @endphp
            @endforeach
          <tr>
            <td colspan="3" class="grand total"><strong>GRAND TOTAL</strong></td>
            <td class="grand total"><strong>{{ number_format($gtotal,0) }}</strong></td>
          </tr>
        </tbody>
      </table>
      {{-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> --}}
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>