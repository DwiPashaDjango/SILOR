@extends('layouts.app')

@section('title', 'Upload Laporan Kasus Yang Dipresentasikan')

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
                    <form action="{{route('mhs.report.uploads.insertLapPresentation')}}" method="POST" enctype="multipart/form-data">
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
                            <input type="file" name="pdf_presentase" id="pdf_presentase" class="form-control @error('pdf_presentase') is-invalid @enderror">
                            @error('pdf_presentase')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Berkas Absensi</label>
                            <input type="file" name="pdf_absensi" id="pdf_absensi" class="form-control @error('pdf_absensi') is-invalid @enderror">
                            @error('pdf_absensi')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Foto Kegiatan</label>
                            <input type="file" name="image_presentase" id="image_presentase" class="form-control @error('image_presentase') is-invalid @enderror">
                            @error('image_presentase')
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