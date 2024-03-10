@extends('layouts.app')

@section('title')
    {{$data->title}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('')}}modules/chocolat/dist/css/chocolat.css">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="tickets">
            <div class="ticket-content">
                <div class="ticket-header">
                    <div class="ticket-sender-picture img-shadow">
                        <img src="{{asset('')}}img/avatar/avatar-5.png" alt="image">
                    </div>
                    <div class="ticket-detail">
                        <div class="ticket-title">
                            <h4>{{$data->user->name}}</h4>
                        </div>
                        <div class="ticket-info">
                            <div class="font-weight-600">{{$data->user->username}}</div>
                        </div>
                    </div>
                </div>
                <div class="ticket-description">
                    <br>
                    <h4>Judul : {{$data->title}}</h4>
                    <br>
                    <h4>Abstrak : </h4> 
                    {!! $data->abstrak !!}

                    @if ($data->image != null && $data->tanggal != null && $data->ruangan != null)
                        <br>
                        <h4>Foto Kegiatan Baca Jurnal : </h4>
                        <div class="gallery">
                            <div class="gallery-item" data-image="{{asset('storage/jurnal/image/' . $data->image)}}" data-title="Image 1"></div>
                        </div>
                    @endif

                    <div class="ticket-divider"></div>
                    <h4>File Jurnal : </h4>
                    <div class="ticket-form">
                        <embed src="{{asset('storage/jurnal/' . $data->user->name . '/' . $data->file)}}" type="application/pdf" width="100%" height="600px" />
                    </div>

                    @if($data->status == 'pending')
                        <div class="mt-3">
                            <button type="button" id="approved" data-id="{{$data->id}}" class="btn btn-success"><i class="fas fa-check"></i> Appreoved Jurnal</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
     <script src="{{asset('')}}modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
     <script>
        $(document).ready(function() {
            $('#approved').click(function(e) {
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
                                window.location.reload()
                            }
                            }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log("I was closed by the timer");
                                window.location.reload()
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