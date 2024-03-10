@extends('layouts.app')

@section('title', 'Data Laporan Kasus')

@section('content')
   <div class="card card-primary">
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
            const table1 = $("#table").DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('/dosens/reports') }}",
                    data: {
                        type: 'normal'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'nim'},
                    {data: 'email'},
                    {data: 'semester'},
                ]
            });
        })
    </script>
@endpush