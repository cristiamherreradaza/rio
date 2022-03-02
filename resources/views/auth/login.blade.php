@extends('layouts.login')

@section('content')

<form method="POST" action="{{ route('login') }}" class="form" id="kt_login_signin_form">
    @csrf

        <div class="form-group py-3 m-0">
            <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" required />
        </div>
        
        @error('email')
        <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="form-group py-3 border-top m-0">
            <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" />
        </div>

        @error('password')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-3">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline m-0 text-muted">
                    <input type="checkbox" name="remember" id="remeber" {{ old('remember') ? 'checked' : '' }} />
                    <span></span>Recuerdame </label>
            </div>

        </div>
        <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-2">
            <div class="my-3 mr-2">
                <span class="text-muted mr-2">No tienes cuenta?</span>
                <a href="javascript:;" id="kt_login_signup" class="font-weight-bold">REGISTRATE</a>
            </div>
            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">INGRESAR</button>
        </div>

</form>

@endsection
