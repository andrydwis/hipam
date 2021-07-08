<table>
    <thead>
        <tr>
            <th><b>Nomor Pelanggan</b></th>
            <th><b>Nama</b></th>
            <th><b>Meter Kubik</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>{{$client->client_id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->usages->first()->meter_cubic ?? 'belum diisi'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>