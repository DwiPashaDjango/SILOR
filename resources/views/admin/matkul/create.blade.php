@extends('layouts.app')

@section('title', 'Tambah Data Mata Kuliah')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <a href="{{route('matkuls')}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{route('matkuls.store')}}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Kode Mata Kuliah</label>
                    <input type="text" name="kd_matkul" value="{{old('kd_matkul')}}" class="form-control @error('kd_matkul') is-invalid @enderror">
                    @error('kd_matkul')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Nama Mata Kuliah</label>
                    <input type="text" name="nm_matkul" value="{{old('nm_matkul')}}" class="form-control @error('nm_matkul') is-invalid @enderror">
                    @error('nm_matkul')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Jumlah SKS</label>
                    <input type="number" name="sks"  value="{{old('sks')}}" class="form-control @error('sks') is-invalid @enderror">
                    @error('sks')
                        <span class="invalid-feedback">
                            {{$message}}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>
    </div>
@endsection