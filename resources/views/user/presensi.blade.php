<x-layout>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <div id="appCapsule">


        <div class="row" style="margin-top: 70px">
            <div class="col">
                <input type="hidden" name="lokasi" id="lokasi">
                <div id="webcam"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if ($check > 0)
                    <button id="takeabsen" class="btn btn-danger btn-block mt-2">
                        <ion-icon name="camera-outline"></ion-icon>Absen Pulang
                    </button>
                @else
                    <button id="takeabsen" class="btn btn-primary btn-block mt-2">
                        <ion-icon name="camera-outline"></ion-icon>Absen Masuk
                    </button>
                @endif

            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div id="map"></div>
            </div>
        </div>

        <audio src="{{asset('assets/audio/notifikasi_in.mp3')}}" id="notifikasi_in"></audio>
        <audio src="{{asset('assets/audio/notifikasi_out.mp3')}}" id="notifikasi_out"></audio>
        <audio src="{{asset('assets/audio/radius.mp3')}}" id="radius"></audio>

    </div>
    @push('my-script')
        <script>
            var notifikasi_in = document.getElementById('notifikasi_in');
            var notifikasi_out = document.getElementById('notifikasi_out');
            // webcam
            Webcam.set({
                height:480,
                width:640,
                image_format: 'jpeg',
                jpeg_quality: 80
            })

            Webcam.attach('#webcam')
            var lokasi = document.getElementById('lokasi');
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }

            function successCallback(position){
                lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
                var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                var circle = L.circle([-7.392515596262893, 108.14699229105807], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 50
                }).addTo(map);
            }

            function errorCallback(){

            }

            $('#takeabsen').click(function(e){
                Webcam.snap(function(uri){
                    image = uri;
                })
                var lokasi = $('#lokasi').val();
                $.ajax({
                    type: "POST",
                    url : "{{route('addPresensi')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        image: image,
                        lokasi: lokasi
                    },
                    cache: false,
                    success: function (response) {
                        var status = response.status
                        if(status == 'success'){
                            if(response.type == 'in'){
                                notifikasi_in.play()
                            } else {
                                notifikasi_out.play()
                            }
                            Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then((result) => {
                                // Jika tombol "OK" ditekan
                                if (result.isConfirmed) {
                                    window.location.href = '/dashboard'; // Ganti dengan URL dashboard Anda
                                }
                            });
                        } else {
                            if(response.type == 'radius'){
                                radius.play();
                            }
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response.message,
                            });
                        }
                    }
                })
            })
        </script>
    @endpush
</x-layout>
