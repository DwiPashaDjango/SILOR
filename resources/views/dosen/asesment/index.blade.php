@extends('layouts.app')

@section('title', 'List Self Asesment')

@section('content')
    <div class="card card-primary">
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

@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#table').DataTable({
                serverSide: true,
                ajax: "{{url('dosens/asesments')}}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'action'},
                ]
            });
        })
    </script>
@endpush