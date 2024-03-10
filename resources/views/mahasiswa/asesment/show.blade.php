@extends('layouts.app')

@section('title')
   {{$data->title}}
@endsection

@section('content')
    <div class="w-100 mb-5 text-center">
        Jika Form Tidak Muncul Silahkan Klik Link berikut : <a target="__blank" href="{{$data->url}}/viewform" style="word-break: break-all">{{$data->url}}/viewform</a>
    </div>
    <iframe class="rounded" id="urls" src="{{$data->url}}/viewform?embedded=true" style="width: 100%; height:500px; background-color:aliceblue" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '".snByac"', function(e) {
                e.preventDefault();
                alert('Oke')
            })
        })
    </script>
@endpush