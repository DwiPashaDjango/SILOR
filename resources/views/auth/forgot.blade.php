@extends('layouts.app') 

@section('title', 'Konfirmasi')

@section('content')
    <div class="row">
        <div class="col-lg-5 mx-auto">
            <div class="card card-primary">
                <div class="card-header"><h4>Confirmation</h4></div>

                <div class="card-body">
                    <p class="text-muted">Konfirmasi Bahwasannya Ini Adalah Saudara {{ Auth::user()->name }}</p>
                    <form method="POST" action="{{route('reset.forgot')}}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" value="{{Auth::user()->email}}" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1">
                            @error('email')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input required type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                <label class="custom-control-label" for="remember-me">Benar Ini Saya</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection