@extends('layouts.app')

@section('title', 'List Jurnal')

@section('content')
@if ($jurnalCount < 3)
    <div class="alert alert-warning">
        <b>Minmal Judul Jurnal Yang Di Upload Adalah 3</b>
    </div>
@endif
<div class="card card-primary">
    <div class="card-header">
        <a href="{{route('mhs.jurnal.uploads')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-lg">
            <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">No</th>
                        <th class="text-white text-center">Judul Jurnal</th>
                        <th class="text-white text-center">File Jurnal</th>
                        <th class="text-white text-center">Status</th>
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
            $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/portal/jurnals/list')}}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'file'},
                    {data: 'status'},
                ]
            })
        })
    </script>
@endpush
