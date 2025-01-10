<body style="background-color:#e9ecef;">
    @include('sweetalert::alert')
    <!-- loader -->
    {{-- <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div> --}}
    <!-- * loader -->
    <x-header></x-header>
        {{$slot}}
    <x-footer></x-footer>

</body>
