@extends('layouts.app')

@section('content')
<div class="container-fluid" style="overflow: hidden;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bj-home">
                <div class="card-header bj-home-header">
                    <h3 class="directionUri" style="color: #000; font-size: 12px;">{{ $_SERVER['REQUEST_URI'] }}</h3>
                </div>
                <div class="card-body bj-home-body">
                    @yield('modules')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection