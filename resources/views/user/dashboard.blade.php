<x-layout>

     <!-- App Capsule -->
     <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar image-container">
                    <img src="{{Storage::url('uploads/karyawan/') . session('user')->foto}}" alt="avatar">
                </div>
                <div id="user-info">
                    <h2 id="user-name">
                    @if (session('user'))
                        {{session('user')->nama_lengkap}}
                    @else
                        Abdi Al A'la
                    @endif
                    </h2>
                    <span id="user-role">
                    @if(session('user'))
                        {{session('user')->jabatan}}
                    @else
                        Head of IT
                    @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($presensi != null)
                                            <img src="{{Storage::url('uploads/absensi/' . $presensi->foto_in)}}" alt="" class="imaged w64">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{$presensi != null ? $presensi->jam_in : "Belum Absen"}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($presensi != null && $presensi->jam_out != null)
                                            <img src="{{Storage::url('uploads/absensi/' . $presensi->foto_out)}}" alt="" class="imaged w64">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{$presensi != null && $presensi->jam_out != null ? $presensi->jam_out : "Belum Absen"}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rekappresensi">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center col" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class="badge bg-danger" style="position: absolute; top:4px; right: 10px; z-index: 999; font-size: 0.6rem;">{{$rekappresensi->jmlHadir}}</span>
                                <ion-icon name="accessibility-outline" class="text-success mb-1" style="font-size: 1.8rem;"></ion-icon>
                                <span style="font-size: 0.9rem; font-weight: 500;">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center col" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class="badge bg-danger" style="position: absolute; top:4px; right: 10px; z-index: 999; font-size: 0.6rem;">{{$rekapizin->jmlIzin != null ? $rekapizin->jmlIzin : 0}}</span>
                                <ion-icon name="newspaper-outline" class="text-primary mb-1" style="font-size: 1.8rem;"></ion-icon>
                                <span style="font-size: 0.9rem; font-weight: 500;"> Izin </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center col" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class="badge bg-danger" style="position: absolute; top:4px; right: 10px; z-index: 999; font-size: 0.6rem;">{{$rekapizin->jmlSakit != null ? $rekapizin->jmlSakit : 0}}</span>
                                <ion-icon name="medkit-outline" class="text-warning mb-1" style="font-size: 1.8rem;"></ion-icon>
                                <span style="font-size: 0.9rem; font-weight: 500;">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center col" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class="badge bg-danger" style="position: absolute; top:4px; right: 10px; z-index: 999; font-size: 0.6rem;">{{$rekappresensi->jmlTerlambat}}</span>
                                <ion-icon name="alarm-outline" class="text-danger mb-1" style="font-size: 1.8rem;"></ion-icon>
                                <span style="font-size: 0.9rem; font-weight: 500;">Telat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rekappresence">
                {{-- <div id="chartdiv"></div>
                <!-- <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence primary">
                                        <ion-icon name="log-in"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Hadir</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Izin</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence warning">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence danger">
                                        <ion-icon name="alarm"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Terlambat</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --> --}}
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($rekapbulan as $value)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <img src="{{Storage::url('uploads/absensi/') . $value->foto_in}}" alt="" class="imaged w32">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in row">
                                        <div class="col-4" style="display: flex; align-items: center;">
                                            <div>{{date('d-m-Y'),strtotime($value->tgl_presensi)}}</div>
                                        </div>
                                        <div class="col-8">
                                            <span class="badge">Jam Masuk : <span class="badge {{$value->jam_in <= "07.00" ? "badge-success" : "badge-danger"}}">{{$value->jam_in}}</span></span>
                                            <span class="badge">Jam Pulang : <span class="badge badge-danger">{{$value != null && $value->jam_out != null ? $value->jam_out : "Belum Absen"}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderBoard as $value)
                            <li>
                                <div class="item">
                                    <img src="{{Storage::url('uploads/absensi/') . $value->foto_in}}" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            {{$value->nama_lengkap}}<br>
                                            <small class="text-muted">{{$value->jabatan}}</small>
                                        </div>
                                        <span class="badge {{$value->jam_in <= "07.00" ? "badge-success" : " badge-danger"}}">{{$value->jam_in}}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</x-layout>
