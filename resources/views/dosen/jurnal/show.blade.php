@extends('layouts.app')

@section('title')
    List Jurnal {{$users->name}}
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">No</th>
                            <th class="text-white text-center">Judul Jurnal</th>
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
            const table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/dosens/jurnals/show')}}/" + "{{$users->id}}",
                processing: false,
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'title'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#approved', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{url('/dosens/jurnals/approved')}}/" + id,
                    method: 'PUT',
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval;
                        Swal.fire({
                            icon: 'success',
                            title: "Berhasil..",
                            html: "I will close in <b></b> milliseconds.",
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
                                table.draw()
                            }
                            }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log("I was closed by the timer");
                                table.draw()
                            }
                        });
                    },
                    error:function(err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
@endpush