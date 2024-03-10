@extends('layouts.app')

@section('title', 'Tambah Indikator Nilai')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <a href="{{route('indikators')}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
           <form action="{{route('indikators.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Rentang Nilai Awal</label>
                    <input type="number" name="nilai_awal" id="nilai_awal" class="form-control @error('nilai_awal') is-invalid @enderror">
                    @error('nilai_awal')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Rentang Nilai Akhir</label>
                    <input type="number" name="nilai_akhir" id="nilai_akhir" class="form-control @error('nilai_akhir') is-invalid @enderror">
                    @error('nilai_akhir')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Nilai Huruf</label>
                    <input type="text" name="huruf" id="huruf" class="form-control @error('huruf') is-invalid @enderror">
                    @error('huruf')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3 mb-3">Tambah</button>
           </form>
        </div>
    </div>
@endsection