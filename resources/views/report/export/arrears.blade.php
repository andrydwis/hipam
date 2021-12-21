<table>
    <tbody>
        <tr>
            <td>HIPAM SWADAYA RW.02 DESA KLAMPOK</td>
        </tr>
        <tr>
            <td>LAPORAN TUNGGAKAN</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td>Total Pendapatan: </td>
            <td>Rp. {{number_format($total,2,',','.')}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$now}}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td>Periode:</td>
            <td>{{$date}}</td>
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
            <th>Total Tagihan</th>
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
            <td>{{$bill->total}}</td>
            <td>{{$bill->status == 'late' ? 'Belum Dibayar' : 'Sudah DIbayar'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>