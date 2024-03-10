@extends('layouts.app')

@section('title', 'Input Data Jurnal')

@push('css')
    <link rel="stylesheet" href="{{asset('')}}modules/summernote/summernote-bs4.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-7">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-body">
                    <form action="{{route('mhs.jurnal.uploads.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Judul Jurnal</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Abstrak</label>
                            <textarea name="abstrak" rows="3" cols="3" class="form-control summernote @error('abstrak') is-invalid @enderror"></textarea>
                            @error('abstrak')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Jurnal (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Link Jurnal</label>
                            <input type="link" name="link" id="link" class="form-control @error('link') is-invalid @enderror">
                            @error('link')
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
            <iframe id="docsViewer" style="width:100%;height:770px;border:1px solid #000;" src=""></iframe>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('')}}modules/summernote/summernote-bs4.js"></script>
    <script>
        $(document).ready(function() {
            $('#file').on('change', function() {
                var file = this.files[0];

                if (file && file.type === 'application/pdf') {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var pdfData = e.target.result;
                        var pdfViewer = document.getElementById('docsViewer');
                        pdfViewer.setAttribute('src', pdfData);
                    };

                    reader.readAsDataURL(file);
                } else {
                    alert('Mohon pilih file PDF');
                    this.value = '';
                }
            });

            $("#title").on('input', function(e) {
                e.preventDefault();
                let title = $(this).val();
                $.ajax({
                    url: "{{url('/portal/jurnals/check')}}/" + title,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            Swal.fire({
                                title: "Whoopss",
                                text: "Jurnal Dengan Judul " + title + " Sudah Terdaftar",
                                icon: "warning"
                            });
                        } else {
                            console.log("Oke")
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
@endpush