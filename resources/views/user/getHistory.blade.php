@if ($histori->isEmpty())
    <div class="alert alert-warning">
        Data Belum Ada
    </div>
@endif
@foreach ($histori as $value)
<ul class="listview image-listview">
    <li>
        <div class="item">
            <img src="{{Storage::url('uploads/absensi/') . $value->foto_in}}" alt="image" class="image">
            <div class="row">
                <div class="col-5" style="display: flex; align-items: center;">
                    <b>{{date('d-m-Y', strtotime($value->tgl_presensi))}}</b>
                </div>
                <div class="col-7" style="gap: 2px;">
                    <span class="badge">Jam Masuk : <span class="badge {{$value->jam_in <= "07.00" ? "badge-success" : " badge-danger"}}">{{$value->jam_in}}</span></span>
                    <span class="badge">Jam Pulang : <span class="badge bg-danger">{{$value->jam_out != null ? $value->jam_out : "Belum Absen"}}</span></span>
                </div>
            </div>
        </div>
    </li>
</ul>
@endforeach
