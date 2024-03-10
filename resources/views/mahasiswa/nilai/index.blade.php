@extends('layouts.app')

@section('title', 'List Mata Kuliah')

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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">Kode Mata Kuliah</th>
                            <th class="text-white text-center">Nama Mata Kuliah</th>
                            <th class="text-white text-center">SKS</th>
                            <th class="text-white text-center">Nilai Akhir</th>
                            <th class="text-white text-center">Nilai Huruf</th>
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
                ajax: "{{url('/portal/list/matkuls')}}",
                processing: false,
                columns: [
                    {data: 'kd_matkul'},
                    {data: 'nm_matkul'},
                    {data: 'sks'},
                    {data: 'nilai'},
                    {data: 'huruf'},
                ]
            });

            $("#add").click(function() {
                $("#matkulModal").modal('show');
            })
        })
    </script>
@endpush