@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

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
            <a href="{{route('matkuls.create')}}" class="btn btn-info btn-sm mr-2" id="add"><i class="fas fa-plus"></i> Tambah</a>
            <button type="button" class="btn btn-primary btn-sm" id="import"><i class="fas fa-file-import"></i> Import Data</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">No</th>
                            <th class="text-white text-center">Kode Mata Kuliah</th>
                            <th class="text-white text-center">Nama Mata Kuliah</th>
                            <th class="text-white text-center">SKS</th>
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
      <form action="{{route('matkuls.import')}}" method="POST" enctype="multipart/form-data">
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
          <a href="{{asset('_file/template_import_matkul.xlsx')}}" download="" class="btn btn-success">Unduh Template Excel</a>
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
                <label for="">Kode Mata Kuliah</label>
                <input type="text" name="kd_matkul" id="kd_matkul" class="form-control">
                <span class="errors_kd_matkul text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="">Nama Mata Kuliah</label>
                <input type="text" name="nm_matkul" id="nm_matkul" class="form-control">
                <span class="errors_nm_matkul text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="">Jumlah SKS</label>
                <input type="number" name="sks" id="sks" class="form-control">
                <span class="errors_sks text-danger"></span>
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
                ajax: "{{url('/admin/matkuls')}}",
                processing: false,
                searching: true,
                bInfo: true,
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'kd_matkul'},
                    {data: 'nm_matkul'},
                    {data: 'sks'},
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
                    url: "{{url('/admin/matkuls/')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $("#editModal").modal('show');
                        $("#editModalLabel").html(res.nm_matkul);

                        $("#id").val(res.id)
                        $("#kd_matkul").val(res.kd_matkul)
                        $("#nm_matkul").val(res.nm_matkul)
                        $("#sks").val(res.sks)
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
                    kd_matkul: $("#kd_matkul").val(),
                    nm_matkul: $("#nm_matkul").val(),
                    sks: $("#sks").val(),
                }

                $.ajax({
                    url: "{{url('/admin/matkuls/')}}/" + id,
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
                            url: "{{url('/admin/matkuls/')}}/" + id,
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