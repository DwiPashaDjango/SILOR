@extends('layouts.app')

@section('title')
    {{$data->title}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('')}}modules/chocolat/dist/css/chocolat.css">
@endpush

@section('content')
@if (session()->has('success'))
<div class="alert alert-success">
    {{session()->get('success')}}
</div>
@endif
<div class="card">
    <div class="card-body">
        <div class="tickets">
            <div class="ticket-content">
                <div class="ticket-header">
                    <div class="ticket-sender-picture img-shadow">
                        <img src="{{asset('')}}img/avatar/avatar-5.png" alt="image">
                    </div>
                    <div class="ticket-detail">
                        <div class="ticket-title">
                            <h4>{{$data->user->name}}</h4>
                        </div>
                        <div class="ticket-info">
                            <div class="font-weight-600">{{$data->user->username}}</div>
                        </div>
                    </div>
                </div>
                <div class="ticket-description">
                    <br>
                    <h4>Judul : {{$data->title}}</h4>
                    <br>
                    <h4>Abstrak : </h4> 
                    {!! $data->abstrak !!}
                    <div class="ticket-divider"></div>
                    @if ($data->image != null && $data->tanggal != null && $data->ruangan != null)
                        <br>
                        <h4>Foto Kegiatan Baca Jurnal : </h4>
                        <div class="gallery">
                            <div class="gallery-item" data-image="{{asset('storage/jurnal/image/' . $data->image)}}" data-title="Image 1"></div>
                        </div>
                    @else 
                        <br>
                        <h4>Upload Kegiatan Baca Jurnal : </h4>
                        <form action="{{route('mhs.jurnal.update', ['id' => $data->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label for="">Tanggal Baca Jurnal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror">
                                @error('tanggal')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Ruangan</label>
                                <input type="text" name="ruangan" id="ruangan" class="form-control @error('ruangan') is-invalid @enderror">
                                @error('ruangan')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Foto Kegiatan Baca Jurnal</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Upload</button>
                        </form>
                    @endif
                    
                    <div class="ticket-divider"></div>
                    <h4>File Jurnal : </h4>
                    <div class="ticket-form">
                        <embed src="{{asset('storage/jurnal/' . $data->user->name . '/' . $data->file)}}" type="application/pdf" width="100%" height="600px" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
     <script src="{{asset('')}}modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
@endpush