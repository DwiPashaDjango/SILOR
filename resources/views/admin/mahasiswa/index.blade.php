@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{session()->get('error')}}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <button type="button" class="btn btn-primary btn-sm" id="import"><i class="fas fa-file-import"></i> Import Data</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">No</th>
                            <th class="text-white text-center">Nama Lengkap</th>
                            <th class="text-white text-center">Nomor Induk Mahasiswa</th>
                            <th class="text-white text-center">Email</th>
                            <th class="text-white text-center">Semester</th>
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
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Data Dosen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('mhs.import')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">File</label>
                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                @error('file')
                    <span class="invalid-feedback">
                        {{$message}}
                    </span>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
          <a href="{{asset('_file/template_import_mhs.xlsx')}}" download="" class="btn btn-success">Unduh Template Excel</a>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
            <input type="hidden" name="id" id="id">
            <div class="form-group mb-3">
                <label for="">Nama Lengkap Mahasiswa</label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="errors_name text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="">Nomor Induk Mahasiswa</label>
                <input type="number" name="username" id="username" class="form-control">
                <span class="errors_username text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="">Email Addres</label>
                <input type="email" name="email" id="email" class="form-control">
                <span class="errors_email text-danger"></span>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="update" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/admin/mahasiswas')}}",
                processing: false,
                searching: true,
                bInfo: true,
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'username'},
                    {data: 'email'},
                    {data: 'semester'},
                    {data: 'action'},
                ]
            });

            $("#import").click(function(e) {
                e.preventDefault();
                $("#importModal").modal('show');
            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.ajax({
                    url: "{{url('/admin/mahasiswas/')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $("#editModal").modal('show');
                        $("#editModalLabel").html(res.name);

                        $("#id").val(res.id)
                        $("#name").val(res.name)
                        $("#username").val(res.username)
                        $("#email").val(res.email)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });

            $("#update").click(function(e) {
                e.preventDefault();
                const id = $("#id").val();
                let datas = {
                    name: $("#name").val(),
                    username: $("#username").val(),
                    email: $("#email").val(),
                }

                $.ajax({
                    url: "{{url('/admin/mahasiswas/')}}/" + id,
                    method: 'PUT',
                    data: datas,
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
                                $("#editModal").modal('hide');
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                table.draw();
                                $("#editModal").modal('hide');
                            }
                        });
                    },
                    error: function(err) {
                        $.each(err.responseJSON.errors, function(index, value) {
                            $("#" + index).addClass('is-invalid');
                            $(".errors_" + index).html(value);
                            setTimeout(() => {
                                $("#" + index).removeClass('is-invalid');
                                $(".errors_" + index).html('');
                            }, 3000);
                        })
                    }
                })
            });

            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin akan menghapus data dosen ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/admin/mahasiswas/')}}/" + id,
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