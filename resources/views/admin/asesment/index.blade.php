@extends('layouts.app')

@section('title', 'List Self Asesment')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
          <a href="{{route('admin.asesments.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped table-hover text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">No</th>
                            <th class="text-white text-center">Judul</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Asesment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="">Judul Asesment</label>
            <input type="text" name="title" id="title" class="form-control">
            <span class="errors_title text-danger"></span>
        </div>
        <div class="form-group">
            <label for="">Link Gogle Forms (Mahasiswa)</label>
            <input type="url" name="url" id="url" class="form-control">
            <span class="errors_url text-danger"></span>
        </div>
        <div class="form-group">
            <label for="">Link Gogle Forms (Dosen)</label>
            <input type="url" name="url_dosen" id="url_dosen" class="form-control">
            <span class="errors_url_dosen text-danger"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="update">Update</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#table').DataTable({
                serverSide: true,
                ajax: "{{url('admin/asesments')}}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#edit', function(e) {
              e.preventDefault();
              let id = $(this).data('id');
              $.ajax({
                url: "{{url('/admin/asesments/edit')}}/" + id,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                  console.log(data);
                  $("#exampleModal").modal('show');
                  $("#id").val(data.id);
                  $("#title").val(data.title);
                  $("#url").val(data.url);
                  $("#url_dosen").val(data.url_dosen);
                },
                error: function(err) {
                  console.log(err);
                }
              })
            });

            $("#update").click(function(e) {
              e.preventDefault();
              let id = $("#id").val();
              let title = $("#title").val();
              let url = $("#url").val();
              let url_dosen = $("#url_dosen").val();

              $.ajax({
                url: "{{url('/admin/asesments/update')}}/" + id,
                method: 'PUT',
                data: {
                  title: title,
                  url: url,
                  url_dosen: url_dosen,
                },
                dataType: 'json',
                success: function(data) {
                  if (data.errors) {
                    $.each(data.errors, function(index, value) {
                        $("#" + index).addClass('is-invalid');
                        $(".errors_" + index).html(value);
                        setTimeout(() => {
                            $("#" + index).removeClass('is-invalid');
                            $(".errors_" + index).html('');
                        }, 3000);
                    })
                  } else {
                    $("#exampleModal").modal('hide');
                    let timerInterval;
                    Swal.fire({
                      icon: "success",
                      title: "Berhasil..",
                      html: "Data akan berubah dalam <b></b> milliseconds.",
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
                        table.draw()
                      }
                    }).then((result) => {
                      /* Read more about handling dismissals below */
                      if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                        table.draw()
                      }
                    });
                  }
                },
                error: function(err) {
                  console.log(err);
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
                            url: "{{url('/admin/asesments/delete')}}/" + id,
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