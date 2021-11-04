@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="bj-logo">
                <div class="text-center">
                    <a href="{{ url('/home') }}">
                        <!-- <img src="{{ asset('storage/garden/logo.png') }}" class="img-responsive" style="width: 200px; height: auto;"> -->
                    </a>
                </div>
            </div>
            <div class="card bj-login">
                <div class="card-header">{{ __('INICIAR SESIÓN') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <div class="input-group my-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" placeholder="Usuario" value="{{ old('id') }}" autocomplete="id" required>
                            @error('id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group my-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-unlock-alt"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="bj-btn-table-delete btn-block" style="border-color: #fd8701;">
                                    {{ __('INGRESAR') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvidé la contraseña') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
