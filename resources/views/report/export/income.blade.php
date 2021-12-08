<table>
    <tbody>
        <tr>
            <td>HIPAM SWADAYA RW.02 DESA KLAMPOK</td>
        </tr>
        <tr>
            <td>LAPORAN PENDAPATAN</td>
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
            <th>Pemakaian Awal</th>
            <th>Pemakaian Terakhir</th>
            <th>Dibayar</th>
            <th>Waktu Bayar</th>
            <th>Keterangan</th>
            <th>Penerima</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
        <tr>
            <td>{{$bill->usage->client->client_id}}</td>
            <td>{{$bill->usage->client->name}}</td>
            <td>{{$bill->usage->client->rt}}</td>
            <td>{{$bill->usage->client->rw}}</td>
            <td>{{$bill->usage->meter_cubic-$bill->meter_cubic}}</td>
            <td>{{$bill->usage->meter_cubic}}</td>
            <td>{{$bill->total}}</td>
            <td>{{$bill->paid_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}}</td>
            <td>{{$bill->fine ? 'Telat Membayar' : '-'}}</td>
            <td>{{$bill->admin ? $bill->admin->name : '-'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>