<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Meteran Bulan Lalu</th>
            <th>Meteran Bulan Ini</th>
            <th>Pemakaian</th>
            <th>Tarif</th>
            <th>Abonemen</th>
            <th>Denda</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usages as $usage)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$usage->month}}</td>
            <td>{{$usage->year}}</td>
            @if($usage->meter_cubic - $usage->bill->meter_cubic >= 0)
            <td>{{$usage->meter_cubic - $usage->bill->meter_cubic}}</td>
            @else
            <td>0</td>
            @endif
            <td>{{$usage->meter_cubic}}</td>
            <td>{{$usage->bill->meter_cubic ?? '-'}}</td>
            <td>{{$usage->bill->cost}}</td>
            <td>{{$usage->bill->subscription}}</td>
            <td>{{$usage->bill->fine ?? 0}}</td>
            <td>{{$usage->bill->total}}</td>
            <td>
                @if($usage->bill)
                @if($usage->bill->status == 'unpaid')
                belum membayar
                @elseif($usage->bill->status == 'late')
                telat membayar
                @elseif($usage->bill->status == 'paid')
                sudah membayar
                @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>