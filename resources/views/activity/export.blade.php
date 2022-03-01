<table>
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>Tahun</b></th>
            <th><b>Bulan</b></th>
            <th><b>Tanggal</b></th>
            <th><b>Nama Teknisi</b></th>
            <th><b>Jenis Kegiatan</b></th>
            <th><b>Jenis Pekerjaan</b></th>
            <th><b>No Surat Tugas</b></th>
            <th><b>Nama Pelanggan</b></th>
            <th><b>RT/RW</b></th>
            <th><b>Catatan</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $activity)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$activity->year}}</td>
            <td>{{$activity->month}}</td>
            <td>{{$activity->created_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}}</td>
            <td>{{$activity->technician->name}}</td>
            <td>{{$activity->activity_type}}</td>
            <td>{{$activity->job_type}}</td>
            <td>{{$activity->assignment_letter_number ?? '-'}}</td>
            <td>{{$activity->name ?? '-'}}</td>
            <td>{{$activity->rt_rw ?? '-'}}</td>
            <td>{{$activity->description}}</td>
        </tr>
        @endforeach
    </tbody>
</table>