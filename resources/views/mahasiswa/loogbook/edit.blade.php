@extends('layouts.app')

@section('title')
    Edit Rekam Medis Dengan Nomor - {{$data->no_medis}}
@endsection

@section('content')
<form action="{{route('mhs.loogbook.update')}}" method="POST">
    @csrf
    <div class="row">
        @foreach ($data->detail as $item)
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <input type="hidden" name="ids[]" id="id" value="{{$item->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">No Rekam Medis</label>
                                    <input type="text" name="no_medis" readonly value="{{$item->no_medis}}" id="no_medis" class="form-control purchase-code @error('no_medis') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Kunjungan</label>
                                    <select name="kunjungan[]" id="kunjungan" class="form-control @error('kunjungan') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{$i}}" {{$item->kunjungan == $i ? 'selected' : ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    @error('kunjungan')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Diagnosis</label>
                                    <input type="text" name="diagnosis[]" value="{{$item->diagnosis}}" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror">
                                    @error('diagnosis')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Diagnosis Banding</label>
                                    <input type="text" name="diagnosis_banding[]" value="{{$item->diagnosis_banding}}" id="diagnosis_banding" class="form-control @error('diagnosis_banding') is-invalid @enderror">
                                    @error('diagnosis_banding')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Terapi</label>
                            <input type="text" name="terapi[]" value="{{$item->terapi}}" id="terapi" class="form-control @error('terapi') is-invalid @enderror">
                            @error('terapi')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100">Simpan</button>
        </div>
    </div>
</form>
@endsection

@push('js')
    <script src="{{asset('') }}modules/cleave-js/dist/cleave.min.js"></script>
    <script src="{{asset('') }}modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
    <script>
        var cleavePC = new Cleave('.purchase-code', {
            delimiter: '',
            blocks: [2, 2, 2, 2],
            uppercase: true
        });
    </script>
@endpush    