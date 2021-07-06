<table>
    <thead>
        <tr>
            <th><b>Nomor Pelanggan</b></th>
            <th><b>Nama</b></th>
            <th><b>RT</b></th>
            <th><b>RW</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
           <td>{{$client->client_id}}</td>
           <td>{{$client->name}}</td>
           <td>{{$client->rt}}</td>
           <td>{{$client->rw}}</td>
        </tr>
        @endforeach
    </tbody>
</table>