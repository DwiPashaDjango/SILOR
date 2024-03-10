@extends('layouts.app')

@section('title', 'Input Data LoogBook')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <form action="{{route('mhs.loogbook.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="status" id="status">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">No Rekam Medis</label>
                                    <input type="text" name="no_medis" id="no_medis" class="form-control purchase-code @error('no_medis') is-invalid @enderror">
                                    @error('no_medis')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Kunjungan</label>
                                    <select name="kunjungan" id="kunjungan" class="form-control @error('kunjungan') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    @error('kunjungan')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Diagnosis</label>
                                    <input type="text" name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror">
                                    @error('diagnosis')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Diagnosis Banding</label>
                                    <input type="text" name="diagnosis_banding" id="diagnosis_banding" class="form-control @error('diagnosis_banding') is-invalid @enderror">
                                    @error('diagnosis_banding')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Terapi</label>
                            <input type="text" name="terapi" id="terapi" class="form-control @error('terapi') is-invalid @enderror">
                            @error('terapi')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-1">
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
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('') }}modules/cleave-js/dist/cleave.min.js"></script>
    <script src="{{asset('') }}modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
    <script>
        var cleavePC = new Cleave('.purchase-code', {
            delimiter: '',
            blocks: [2, 2, 2, 2],
            uppercase: true
        });

        $(document).ready(function() {
            $("#table").DataTable({
                "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
                "paging": false,//Dont want paging                
                "bPaginate": false,//Dont want paging  
                "searching": false
            })

            $("#no_medis").on('input', function(e) {
                let no_medis = $("#no_medis").val();
                $.ajax({
                    url: "{{url('/portal/loogbook/list/check')}}/" + no_medis,
                    method: "GET",
                    dataType: 'json',
                    success: function(res) {
                        let html = '';
                        if (res.detail_count > 0) {
                            $("#status").val('available');
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
                            $("#status").val('not_available');
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
        })
    </script>
@endpush    