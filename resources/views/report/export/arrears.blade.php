<table>
    <tbody>
        <tr>
            <td>Total Tunggakan: </td>
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
            <th>Total Tunggakan</th>
            <th>Tagihan Terakhir</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
        <tr>
            <td>{{$bill->usage->client->client_id}}</td>
            <td>{{$bill->usage->client->name}}</td>
            <td>{{$bill->usage->client->rt}}</td>
            <td>{{$bill->usage->client->rw}}</td>
            <td>{{$bill->allArrears($bill->usage->client->id)}} Bulan</td>
            <td>Rp. {{number_format($bill->total,2,',','.')}}</td>
            <td>{{$bill->status == 'late' ? 'Belum Dibayar' : 'Sudah DIbayar'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>