@extends('layouts.app')

@section('title', 'Daftar Jurnal Di Terima')

@section('content')
    @foreach ($data as $item)
        <div class="card">
            <div class="card-body p-1">
                <div class="row mt-3 justify-content-center align-items-center mx-2">
                    <div class="col-sm-12 col-md-12 ps-4 text-start" style="text-align: justify !important">
                        <h4>
                            <a href="{{route('mhs.jurnal.edit', ['id' => $item->id])}}" class="text-primary text-start fs-4 mt-3 text-decoration-none">{{$item->title}}</a>
                        </h4>
                        <div class="row text-start">
                            <ul class="list-inline mt-2" style="font-size: 14px">
                                <li class="list-inline-item ml-3 mr-3"><i class="fas fa-calendar mr-2"></i><span class="text-body-tertiary">{{\Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : 'Belum Mengisi Tanggal Baca Jurnal'}}</span></li>
                                @if ($item->status == 'paid')
                                    <li class="list-inline-item ms-1"><i class="fas fa-check mr-2 text-success"></i><span class="text-body-tertiary text-success">Approved</span></li>
                                @else
                                    <li class="list-inline-item ms-1"><i class="fas fa-exclamation mr-2 text-warning"></i></i><span class="text-body-tertiary text-warning">Prosess</span></li>
                                @endif
                            </ul>
                        </div>
                        <p id="isiAgenda" class="text-start" style="text-align: justify !important">
                            @php
                                $decodedText = $item->abstrak;
                                $limit = 400;
                                $trimmedText = substr(strip_tags($decodedText), 0, $limit);
                                if (strlen(strip_tags($decodedText)) > $limit) {
                                    $trimmedText .= '...';
                                }
                            @endphp 
                            {!! $trimmedText !!}
                        </p>
                        <hr class="divide">
                        <ul class="list-inline mt-2 text-start" style="font-size: 16px">
                            <li class="list-inline-item">
                                <a href="{{route('mhs.jurnal.edit', ['id' => $item->id])}}" class="text-body-secondary link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" id="read">Detail Jurnal<i class="bi bi-arrow-right-square ms-1"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-3 d-flex justify-content-center">
        {{$data->links()}}
    </div>
@endsection