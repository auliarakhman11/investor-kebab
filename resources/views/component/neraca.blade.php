<div class="row">
  
  <div class="col-12">
    <table class="table table-sm" width="100%">
      <thead>
          <tr class="bg-scondary">
              <th>Akun</th>
              <th>Saldo</th>
          </tr>
      </thead>
      <tbody>
        @php
            $total_debit = 0;
            $total_kredit = 0;
        @endphp
        @foreach ($neraca as $d)
        <tr>
          <td  >{{ $d->nm_akun }}</td>
          @php
              $sub_total = $d->ttl_debit - $d->ttl_kredit;
          @endphp
          @php
              $total_debit += $sub_total;
          @endphp
          <td>{{ number_format($sub_total) }}</td>
         
          
        </tr>
        @endforeach
        
      </tbody>
      <tfoot>
        <tr>
          <td><strong>Total</strong></td>
          <td><strong>{{ number_format($total_debit) }}</strong></td>
        </tr>
      </tfoot>
  </table>
  </div>
</div>
