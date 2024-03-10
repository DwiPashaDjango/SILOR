@extends('layouts.app')

@section('title')
    {{ $data->name }}
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <a href="{{route('dosen.mhs')}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">Kode Mata Kuliah</th>
                        <th class="text-white text-center">Nama Mata Kuliah</th>
                        <th class="text-white text-center">SKS</th>
                        <th class="text-white text-center">Nilai Akhir</th>
                        <th class="text-white text-center">Nilai Huruf</th>
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

@push('modal')
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
                <label for="">Nilai</label>
                <input type="text" name="bobot" id="bobot" class="form-control">
                <span class="errors_bobot text-danger"></span>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="update" class="btn btn-primary">Simpan</button>
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
                ajax: "{{ url('/dosens/mahasiswas/' . $data->username) }}",
                processing: false,
                searching: true,
                info: true,
                columns: [
                    { data: 'kd_matkul', name: 'kd_matkul' },
                    { data: 'nm_matkul', name: 'nm_matkul' },
                    { data: 'sks', name: 'sks' },
                    { data: 'bobot', name: 'bobot' },
                    { data: 'huruf', name: 'huruf' },
                    { data: 'action', name: 'action' },
                ]
            });

            $(document).on('click', '#add', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $("#bobot").val('');
                $.ajax({
                    url: "{{url('/dosens/mahasiswas/add/')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $("#editModal").modal('show');
                        $("#editModalLabel").html(res.matkul.nm_matkul);

                        $("#id").val(res.id)
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
                    bobot: $("#bobot").val(),
                }

                $.ajax({
                    url: "{{url('/dosens/mahasiswas/insertNilai/')}}/" + id,
                    method: 'PUT',
                    data: datas,
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval;
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil..",
                            html: "Data akan di tersimpan dalam <b></b> milliseconds.",
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
                                $("#bobot").val('')
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                table.draw();
                                $("#editModal").modal('hide');
                                $("#bobot").val('')
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

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.ajax({
                    url: "{{url('/dosens/mahasiswas/add/')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $("#editModal").modal('show');
                        $("#editModalLabel").html(res.matkul.nm_matkul);

                        $("#id").val(res.id)
                        $("#bobot").val(res.bobot)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });

            $(document).on('click', '#locked', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin ingin mengunci nilai akhir ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Kunci",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('/dosens/mahasiswas/lockNilai/')}}/" + id,
                            method: 'PUT',
                            dataType: 'json',
                            success: function(data) {
                                let timerInterval;
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil..",
                                    html: "Nilai akan di terkunci dalam <b></b> milliseconds.",
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