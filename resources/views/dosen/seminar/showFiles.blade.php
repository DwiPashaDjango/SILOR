@extends('layouts.app')

@section('title')
    {{$data->kegiatan}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('')}}modules/summernote/summernote-bs4.css">
@endpush

@section('content')
<div class="card card-primary mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Nama Mahasiswa</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->user->name}} - {{$data->user->username}}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Kegiatan</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->kegiatan}}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Pelaksana</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->pelaksana}}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Tempat</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->tempat}}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Tanggal</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($data->tgl_selesai)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Foto Kegiatan</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0"><a href="{{$data->link}}" target="__blank">{{$data->link}}</a></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if ($data->status == 'tidak' && $data->reward == null)
        <div class="col-lg-6">
            <embed src="{{asset('storage/seminar/docs/' . $data->docs)}}" type="application/pdf" width="100%" height="600px" />
        </div>
        <div class="col-lg-6">
            <embed src="{{asset('storage/seminar/sertifikat/' . $data->sertifikat)}}" type="application/pdf" width="100%" height="600px" />
        </div>
    @else
        <div class="col-lg-4">
            <embed src="{{asset('storage/seminar/docs/' . $data->docs)}}" type="application/pdf" width="100%" height="600px" />
        </div>
        <div class="col-lg-4">
            <embed src="{{asset('storage/seminar/sertifikat/' . $data->sertifikat)}}" type="application/pdf" width="100%" height="600px" />
        </div>
        <div class="col-lg-4">
            <embed src="{{asset('storage/seminar/reward/' . $data->reward)}}" type="application/pdf" width="100%" height="600px" />
        </div>
    @endif
</div>
@endsection

@push('js')
    <script src="{{asset('')}}modules/summernote/summernote-bs4.js"></script>
@endpush