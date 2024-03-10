@extends('layouts.app')

@section('title', 'Data Semester Mahasiswa')

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
    <div class="card-header">
        <button type="button" id="add" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">No</th>
                        <th class="text-white text-center">Nama</th>
                        <th class="text-white text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('admin.semesters.store')}}" method="POST">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
            <div class="form-group">
                <label for="">Pilih Semester</label>
                <input type="text" name="name" id="nmae" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <span class="invalid-feedback">
                        {{$message}}
                    </span>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

@push('js')
    <script src="{{ asset('') }}modules/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('')}}modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/admin/semesters')}}",
                processing: true,
                info: true,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action' },
                ]
            });

            $("#add").click(function() {
                $("#exampleModal").modal('show')
            })

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
                            url: "{{url('/admin/semesters/destroy')}}/" + id,
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