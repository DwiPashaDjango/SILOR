@extends('layouts.app') 

@section('title', 'Reset Password')

@section('content')
    <div class="row">
        <div class="col-lg-5 mx-auto">
            <div class="card card-primary">
                <div class="card-header"><h4>Reset Password</h4></div>

                <div class="card-body">
                    <p class="text-muted">Silahkan Masukan Password Baru</p>
                    <form method="POST" action="{{route('reset.save')}}">
                        @csrf
                        <input type="hidden" name="email" id="email" value="{{$data->email}}">
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Confirmation Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection