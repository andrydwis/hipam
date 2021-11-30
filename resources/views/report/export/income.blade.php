<table>
    <tbody>
        <tr>
            <td>Total Pendapatan: </td>
            <td>Rp. {{number_format($total,2,',','.')}}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Nomor Pelanggan</th>
            <th>Nama</th>
            <th>RT</th>
            <th>RW</th>
            <th>Pemakaian Terakhir</th>
            <th>Tagihan Terakhir</th>
            <th>Waktu Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
        <tr>
            <td>{{$bill->usage->client->client_id}}</td>
            <td>{{$bill->usage->client->name}}</td>
            <td>{{$bill->usage->client->rt}}</td>
            <td>{{$bill->usage->client->rw}}</td>
            <td>{{$bill->meter_cubic}} m<sup>3</sup></td>
            <td>Rp. {{number_format($bill->total,2,',','.')}}</td>
            <td>{{$bill->paid_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
