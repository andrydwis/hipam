<table>
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>Nomor Pelanggan</b></th>
            <th><b>Nama</b></th>
            <th><b>Meter Kubik</b></th>
            <th><b>Tarif</b></th>
            <th><b>Abonemen</b></th>
            <th><b>Denda</b></th>
            <th><b>Total</b></th>
            <th><b>Status</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($usages as $usage)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$usage->client->client_id}}</td>
            <td>{{$usage->client->name}}</td>
            <td>{{$usage->meter_cubic}}</td>
            <td>{{$usage->bill->cost}}</td>
            <td>{{$usage->bill->subscription}}</td>
            <td>{{$usage->bill->fine ?? '-'}}</td>
            <td>{{$usage->bill->total}}</td>
            <td>
                @if($usage->bill->status == 'unpaid')
                belum membayar
                @elseif($usage->bill->status == 'late')
                telat membayar
                @elseif($usage->bill->status == 'paid')
                sudah membayar
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>