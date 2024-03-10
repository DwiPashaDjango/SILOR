@extends('layouts.app')

@section('title')
    Laporan Kasus {{$data->name}}
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Data Laporan Kasus</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Judul Laporan</th>
                            <th class="text-center text-white">Berkas Laporan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-primary mt-3">
        <div class="card-header">
            <h4>Data Laporan Kasus Yang Dipresentasikan</h4>
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
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            const table1 = $("#table").DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('dosens/reports/show') }}/" + "{{$data->id}}",
                    data: {
                        type: 'normal'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'berkas'},
                ]
            });

            const table2 = $("#table2").DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('dosens/reports/show') }}/" + "{{$data->id}}",
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
                ]
            });
        })
    </script>
@endpush