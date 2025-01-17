<x-layout>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{$i}}" {{date("m") == $i ? 'selected' : ''}}>{{$namabulan[$i]}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
                            @php
                                $tahunmulai = 2024;
                                $tahunsekarang = date("Y");
                            @endphp
                            @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                                <option value="{{$tahun}}" {{ date("Y") == $tahun ? 'selected' : ''}}>{{$tahun}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="getData"><ion-icon name="search-outline"></ion-icon>Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="showhistori"></div>
    </div>
    @push('my-script')
    <script>
            $(function () {
                $('#getData').click(function(){
                    var bulan = $('#bulan').val();
                    var tahun = $('#tahun').val();
                    $.ajax({
                        type: "POST",
                        url: "{{route('getHistory')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            bulan: bulan,
                            tahun: tahun
                        },
                        cache: false,
                        success: function (response) {
                            $('#showhistori').html(response);
                        }
                    })
                })
            })
    </script>
    @endpush

</x-layout>
