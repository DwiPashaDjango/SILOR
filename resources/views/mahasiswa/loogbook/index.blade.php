@extends('layouts.app')

@section('title', 'List LoogBook')

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
            <a href="{{route('mhs.loogbook.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah LoogBook</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">No Rekam Medis</th>
                            <th class="text-center text-white">Kunjungan</th>
                            <th class="text-center text-white">Diagnosis</th>
                            <th class="text-center text-white">Diagnosis Banding</th>
                            <th class="text-center text-white">Terapi</th>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="">No Rekam Medis</label>
                        <input type="text" name="no_medis" id="no_medis" class="form-control purchase-code">
                        <span class="errors_no_medis text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="">Kunjungan</label>
                        <select name="kunjungan" id="kunjungan" class="form-control">
                            <option value="">- Pilih -</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <span class="errors_kunjungan text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="">Diagnosis</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                        <span class="errors_diagnosis text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="">Diagnosis Banding</label>
                        <input type="text" name="diagnosis_banding" id="diagnosis_banding" class="form-control">
                        <span class="errors_diagnosis_banding text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="">Terapi</label>
                <input type="text" name="terapi" id="terapi" class="form-control">
                <span class="errors_terapi text-danger"></span>
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


<div class="modal fade" id="detailRekamMedis" tabindex="-1" role="dialog" aria-labelledby="detailRekamMedisLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailRekamMedisLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">Rekam Medis</th>
                        <th class="text-white text-center">Kunjungan</th>
                        <th class="text-white text-center">Diagnosis</th>
                        <th class="text-white text-center">Diagnosis Banding</th>
                        <th class="text-white text-center">Terapi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="update" class="btn btn-primary">Update</button>
      </div> --}}
    </div>
  </div>
</div>
@endpush

@push('js')
    <script src="{{asset('') }}modules/cleave-js/dist/cleave.min.js"></script>
    <script src="{{asset('') }}modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
    <script>
        $(document).ready(function() {
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/portal/loogbook/list')}}",
                processing: false,
                searching: true,
                bInfo: true,
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'no_medis'},
                    {data: 'kunjungan'},
                    {data: 'diagnosis'},
                    {data: 'diagnosis_banding'},
                    {data: 'terapi'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#detail', function(e) {
                e.preventDefault();
                const no_medis = $(this).data('id');
                console.log(no_medis);
                $.ajax({
                    url: "{{url('/portal/loogbook/list/check')}}/" + no_medis,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $("#detailRekamMedis").modal('show');
                        $("#detailRekamMedisLabel").html(res.no_medis);
                        let html = '';
                        if (res.detail_count > 0) {
                            $.each(res.detail, function(index, value) {
                                html += `<tr>
                                            <td>${value.no_medis}</td>
                                            <td>${value.kunjungan}</td>
                                            <td>${value.diagnosis}</td>
                                            <td>${value.diagnosis_banding}</td>
                                            <td>${value.terapi}</td>
                                        </tr>`;
                            });
                            $("#tbody").html(html)
                        } else {
                            html += `<tr>
                                        <td colspan="5">No data available in table</td>
                                    </tr>`;
                            $("#tbody").html(html)
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
                            url: "{{url('/portal/loogbook/list/delete')}}/" + id,
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

        var cleavePC = new Cleave('.purchase-code', {
            delimiter: '',
            blocks: [2, 2, 2, 2],
            uppercase: true
        });
    </script>
@endpush