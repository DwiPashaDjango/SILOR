@extends('layouts.app')

@section('title', 'Upload Laporan Kasus')

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-body">
                    <form action="{{route('mhs.report.uploads.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Judul Laporan</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Berkas Laporan</label>
                            <input type="file" name="pdf_normal" id="pdf_normal" class="form-control @error('pdf_normal') is-invalid @enderror">
                            @error('pdf_normal')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection