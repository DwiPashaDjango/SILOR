@extends('layouts.app')

@section('title', 'List Laporan Kasus')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Data Laporan Kasus</h4>
            <div class="card-header-action dropdown">
                <a href="{{route('mhs.report.uploads')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Laporan Kasus</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Judul Laporan</th>
                            <th class="text-center text-white">Berkas Laporan</th>
                            <th class="text-center text-white">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-primary mt-3">
        <div class="card-header">
            <h4>Data Laporan Kasus Yang Dipresentasikan</h4>
            <div class="card-header-action dropdown">
                <a href="{{route('mhs.report.uploads.presentase')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Laporan Kasus Yang Dipresentasikan</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped text-center" id="table2" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Judul Laporan</th>
                            <th class="text-center text-white">Berkas Laporan</th>
                            <th class="text-center text-white">Berkas Absensi</th>
                            <th class="text-center text-white">Foto Kegiatan</th>
                            <th class="text-center text-white">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modal')
<div class="modal fade" id="modalNormal" tabindex="-1" role="dialog" aria-labelledby="modalNormalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNormalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="pdfNormal" style="width:100%;height:500px;border:1px solid #000;" src=""></iframe>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
<div class="modal fade" id="modalPresentase" tabindex="-1" role="dialog" aria-labelledby="modalPresentaseLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPresentaseLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="pdfPrensentase" style="width:100%;height:500px;border:1px solid #000;" src=""></iframe>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const table1 = $("#table").DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('/portal/report/list') }}",
                    data: {
                        type: 'normal'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'berkas'},
                    {data: 'action'},
                ]
            });

            const table2 = $("#table2").DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('/portal/report/list') }}",
                    data: {
                        type: 'presentase'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'berkas'},
                    {data: 'berkas_absensi'},
                    {data: 'kegiatan'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#deleteNormal', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin akan menghapus data kasus ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/portal/report/list/delete')}}/" + id,
                            method: 'DELETE',
                            data: {
                                type: 'normal'
                            },
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
                                        table1.draw();
                                    }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        table1.draw();
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

            $(document).on('click', '#deletePresentase', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin akan menghapus data kasus ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/portal/report/list/delete')}}/" + id,
                            method: 'DELETE',
                            data: {
                                type: 'presentase'
                            },
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
                                        table2.draw();
                                    }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        table2.draw();
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