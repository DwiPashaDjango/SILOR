@extends('layouts.app')

@section('title', 'Daftar Mata Kuliah Yang Belum Lulus')

@section('content')
<div class="card card-primary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">Kode Mata Kuliah</th>
                        <th class="text-white text-center">Nama Mata Kuliah</th>
                        <th class="text-white text-center">SKS</th>
                        <th class="text-white text-center">Status</th>
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
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/portal/list/matkuls/not-graduated')}}",
                processing: false,
                searching: true,
                bInfo: true,
                columns: [
                    {data: 'kd_matkul'},
                    {data: 'nm_matkul'},
                    {data: 'sks'},
                    {data: 'status'},
                ]
            });
        })
    </script>
@endpush