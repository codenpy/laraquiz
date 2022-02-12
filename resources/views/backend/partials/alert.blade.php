@if(session()->has('msg'))
    @push('script')
        <script>
            window.addEventListener('load', function () {
                iziToast.{{session('type')}}({
                    title: "{!! session('msg') !!}",
                    position: "topRight",
                });
            });
        </script>
    @endpush
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

