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
        <img src="{{public_path('img')}}/kebabyasmin.jpeg">
      </div>
      <h1>Gaji Periode {{ date("d M Y", strtotime($dt_gaji->tgl1)).'~'.date("d M Y", strtotime($dt_gaji->tgl2)) }}</h1>
      <div id="company" class="clearfix">
        <div>Kebab Yasmin</div>
        <div>081349433414</div>
        <div>kebabyasminofficial@gmail.com</div>
        <div></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Gaji Bulanan</div>

        <div><span>Nama</span> {{ $dt_gaji->nama }}</div>
        <div><span>Periode</span> {{ date("d M Y", strtotime($dt_gaji->tgl1)).'~'.date("d M Y", strtotime($dt_gaji->tgl2)) }}</div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>Penjualan</th>
            <th>Gaji Pokok</th>
            <th>Persen<br>Penjualan</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ number_format($dt_gaji->pendapatan,0) }}</td>
                <td style="text-align: center;">{{ number_format($dt_gaji->gapok,0) }}</td>
                <td style="text-align: center;">{{ $dt_gaji->persen }}%</td>
            </tr>
        </tbody>
        <tbody>
                
            <tr>
                <td colspan="2" class="grand total"><strong>Gaji Pokok</strong></td>
                <td class="grand total"><strong>{{ number_format($dt_gaji->gapok,0) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="grand total"><strong>Gaji Persen</strong></td>
                <td class="grand total"><strong>{{ number_format($dt_gaji->gaji_persen,0) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="grand total"><strong>Kasbon</strong></td>
                <td class="grand total"><strong>{{ number_format($dt_gaji->kasbon,0) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="grand total"><strong>Total Gaji</strong></td>
                <td class="grand total"><strong>{{ number_format($dt_gaji->gapok + $dt_gaji->gaji_persen + $dt_gaji->kasbon,0) }}</strong></td>
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