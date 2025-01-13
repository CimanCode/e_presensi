<x-layout>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Izin Atau Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            @if ($izin->isEmpty())
                <div class="alert alert-warning">
                    Data Belum Ada
                </div>
            @endif
            @foreach ($izin as $value)
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div>
                                <b>{{date('d-m-Y', strtotime($value->tgl_izin))}} ({{$value->status == 'sakit' ? 'Sakit' : 'Izin'}})</b><br>
                                <small class="text-muted">Keterangan : {{$value->keterangan}}</small>
                            </div>
                            @if ($value->status_approved == 'Pending')
                                <span class="badge badge-warning">Waiting</span>
                            @elseif ($value->status_approved == 'Sukses')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </div>
                    </div>
                </li>
            </ul>
            @endforeach
        </div>
    </div>
    <div class="fab-button bottom-right">
        <a href="{{route('buatIzin')}}" class="fab" style="margin-bottom: 70px;"><ion-icon name="add-outline"></ion-icon></a>
    </div>
</x-layout>
