@extends('layouts.app')

@section('title', 'List Seminar')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <a href="{{route('mhs.seminar.uploads')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Seminar</a>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Jenis Seminar</th>
                            <th class="text-center text-white">Kegiatan</th>
                            <th class="text-center text-white">Pelaksana</th>
                            <th class="text-center text-white">Tempat</th>
                            <th class="text-center text-white">Tanggal</th>
                            <th class="text-center text-white">Action</th>
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
    <script>
        $(document).ready(function() {
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/portal/seminars/list')}}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'jenis'},
                    {data: 'kegiatan'},
                    {data: 'pelaksana'},
                    {data: 'tempat'},
                    {data: 'tanggal'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin akan menghapus data loogbook ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/portal/seminars/list/delete')}}/" + id,
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
        })
    </script>
@endpush