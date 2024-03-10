@extends('layouts.app')

@section('title')
    {{ $data->name }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('')}}modules/jquery-selectric/selectric.css">
@endpush

@section('content')
@if (session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
@endif
<div class="card card-primary">
    <div class="card-body">
        <form action="{{route('admin.nilai.mhs.store')}}" method="POST">
            @csrf
            <input type="hidden" name="users_id" id="users_id" value="{{$data->id}}">
            <div class="row">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="">Mahasiswa</label>
                        <input type="text" name="" id="" class="form-control" value="{{$data->name}}" disabled>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="">Pilih Mata Kuliah</label>
                        <select class="form-control selectric @error('matkuls_id') is-invalid @enderror" name="matkuls_id[]" multiple="">
                            <option value="">- Pilih -</option>
                            @foreach ($matkul as $item)
                                <option value="{{$item->id}}">{{ $item->kd_matkul }} - {{ $item->nm_matkul }}</option>
                            @endforeach
                        </select>
                        @error('matkuls_id')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for=""></label>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">Kode Mata Kuliah</th>
                        <th class="text-white text-center">Nama Mata Kuliah</th>
                        <th class="text-white text-center">SKS</th>
                        <th class="text-white text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('') }}modules/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('')}}modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{ url('/admin/nilais/' . $data->id) }}",
                processing: true,
                searching: true,
                info: true,
                columns: [
                    { data: 'kd_matkul', name: 'kd_matkul' },
                    { data: 'nm_matkul', name: 'nm_matkul' },
                    { data: 'sks', name: 'sks' },
                    { data: 'action', name: 'action' },
                ]
            });

            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin akan menghapus data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/admin/nilais/')}}/" + id,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(data) {
                                let timerInterval;
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil..",
                                    html: "Data akan di update dalam <b></b> milliseconds.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector("b");
                                        timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                        table.draw();
                                    }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        table.draw();
                                    }
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                });
            });
        });
    </script>
@endpush