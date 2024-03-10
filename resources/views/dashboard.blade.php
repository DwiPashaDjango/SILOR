@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
   @role('Mahasiswa')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah List LoogBook</h4>
                    </div>
                    <div class="card-body">
                        {{$logbookCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Kasus</h4>
                    </div>
                    <div class="card-body">
                        {{$reportCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Seminar Internasional</h4>
                    </div>
                    <div class="card-body">
                        {{$seminarInternasionalCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Seminar Nasional</h4>
                    </div>
                    <div class="card-body">
                        {{$SeminarNasioanlCount}}
                    </div>
                </div>
            </div>
        </div>
    </div>
   @endrole
@endsection