<x-layout>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin Atau Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <form action="{{route('prosesIzin')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" name="tgl_izin" id="datepicker" placeholder="Tanggal Izin/Sakit" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="status" id="keterangan" class="form-control">
                                <option value="">Izin/Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" placeholder="Keterangan" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('my-script')
        <script>
            $( function() {
                $( "#datepicker" ).datepicker({
                    dateFormat: "yy-mm-dd"
                    ,	duration: "fast"
                });
            } );
        </script>
    @endpush
</x-layout>
