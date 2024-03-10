@extends('layouts.app')

@section('title', 'Data Asesment Mahasiswa')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card card-primary">
            <div class="card-header">
                <a href="{{route('admin.asesments')}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{route('admin.asesments.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Judul Asesment</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Link Gogle Forms (Mahasiswa)</label>
                        <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror">
                        @error('url')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Link Gogle Forms (Dosen)</label>
                        <input type="url" name="url_dosen" id="url_dosen" class="form-control @error('url_dosen') is-invalid @enderror">
                        @error('url_dosen')
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
    <div class="col-lg-5">
        <iframe id="urls" src="" style="width: 100%; height:500px; border:1px solid #000;" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#url').on('input', function() {
                let urls = $(this).val();
                $("#urls").attr('src', urls + '/viewform?embedded=true')
            });
        })
    </script>
@endpush
