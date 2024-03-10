@extends('layouts.app')

@section('title')
    List Seminar {{$data->name}}
@endsection 

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Jenis Seminar</th>
                            <th class="text-center text-white">Kegiatan</th>
                            <th class="text-center text-white">Pelaksana</th>
                            <th class="text-center text-white">Tempat</th>
                            <th class="text-center text-white">Tanggal</th>
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

@push('js')
    <script>
        $(document).ready(function() {
            $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/dosens/seminars/show')}}/" + "{{$data->id}}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'jenis'},
                    {data: 'kegiatan'},
                    {data: 'pelaksana'},
                    {data: 'tempat'},
                    {data: 'tanggal'},
                    {data: 'action'},
                ]
            });
        })
    </script>
@endpush