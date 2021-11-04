@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('VERIFICA TU CORREO ELECTRONICO') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('SE HA ENVIADO UN NUEVO ENLACE DE VERIFICACION A SU DIRECCION DE CORREO ELECTRONICO') }}
                        </div>
                    @endif

                    {{ __('ANTES DE CONTINUAR POR FAVOR REVISE SU CORREO ELECTRONICO PARA UN ENLACE DE VERIFICACION') }}
                    {{ __('SI NO HA RECIBIDO EL CORREO') }}, <a href="{{ route('verification.resend') }}">{{ __('CLICK AQUI PARA SOLICITAR OTRO ENLACE') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
