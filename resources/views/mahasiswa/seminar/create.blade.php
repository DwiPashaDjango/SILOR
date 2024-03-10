@extends('layouts.app')

@section('title', 'Input Data Seminar')

@push('css')
    <link rel="stylesheet" href="{{asset('')}}modules/summernote/summernote-bs4.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-body">
                    <form action="{{route('mhs.seminar.uploads.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Jenis Seminar</label>
                                    <select name="jenis" id="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        <option value="nasional">Nasional</option>
                                        <option value="internasional">Internasional</option>
                                    </select>
                                    @error('jenis')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Kegiatan</label>
                                    <input type="text" name="kegiatan" id="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror">
                                    @error('kegiatan')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Pelaksana</label>
                                    <input type="text" name="pelaksana" id="pelaksana" class="form-control @error('pelaksana') is-invalid @enderror">
                                    @error('pelaksana')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Tempat</label>
                                    <input type="text" name="tempat" id="tempat" class="form-control @error('tempat') is-invalid @enderror">
                                    @error('tempat')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Tanggal Mulai</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror">
                                    @error('tanggal')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Tanggal Selesai</label>
                                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control @error('tgl_selesai') is-invalid @enderror">
                                    @error('tgl_selesai')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Dokumen</label>
                                    <input type="file" name="docs" id="docs" class="form-control @error('docs') is-invalid @enderror">
                                    @error('docs')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Sertifikat</label>
                                    <input type="file" name="sertifikat" id="sertifikat" class="form-control @error('sertifikat') is-invalid @enderror">
                                    @error('sertifikat')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Foto Kegiatan (Link GDrive)</label>
                                    <input type="link" name="link" id="link" class="form-control @error('link') is-invalid @enderror">
                                    @error('link')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Reward</label>
                                    <div class="form-group">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" id="check2" value="Tidak Ada" class="selectgroup-input" checked>
                                                <span class="selectgroup-button">Tidak Ada</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" id="check1" value="Ada" class="selectgroup-input">
                                                <span class="selectgroup-button">Ada</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="showReward">
                                <div class="form-group">
                                    <label for="">File</label>
                                    <input type="file" name="reward" id="reward" class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" id="status">
                        <button type="submit" class="btn btn-primary w-100 mt-2">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <iframe id="docsViewer" style="width:100%;height:520px;border:1px solid #000;" src=""></iframe>
            <iframe id="sertifikatViewer" style="width:100%;height:520px;border:1px solid #000;" src=""></iframe>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('')}}modules/summernote/summernote-bs4.js"></script>
    <script>
        $(document).ready(function() {
            $('#docs').on('change', function() {
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
            $('#sertifikat').on('change', function() {
                var file = this.files[0];

                if (file && file.type === 'application/pdf') {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var pdfData = e.target.result;
                        var pdfViewer = document.getElementById('sertifikatViewer');
                        pdfViewer.setAttribute('src', pdfData);
                    };

                    reader.readAsDataURL(file);
                } else {
                    alert('Mohon pilih file PDF');
                    this.value = '';
                }
            });

            $("#showReward").css('display', 'none');
            $("#status").val('Tidak Ada');

            $("#check1").change(function(e) {
                e.preventDefault();
                if (this.checked) {
                    $("#status").val($(this).val());
                    $("#showReward").css('display', 'block');
                    $('#reward').prop('required', true);
                } else {
                    $('#reward').prop('required', false);
                }
            })

            $("#check2").change(function(e) {
                e.preventDefault();
                let status = $(this).val()
                $("#status").val(status);
                $("#showReward").css('display', 'none');
                $('#reward').prop('required', false);
            })
        })
    </script>
@endpush