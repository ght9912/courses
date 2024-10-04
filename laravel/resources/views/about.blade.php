@extends('layouts.blog')


@section("titulo-pagina")
   {{$setting->titulo}}
@endsection

@section("subtitulo-pagina")
    {{$setting->subtitulo}}
@endsection

@section("imagen"){{ asset('assets/img/post-bg.jpg') }}@endsection

@section("content")
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        @if ($setting->contenido!="" &&$setting->contenido!=null)
            <p>{{$setting->contenido}}</p>
        @endif
        </div>
    </div>
@endsection
