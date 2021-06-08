@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('To konto jest zablokowane') }}</div>

                <div class="card-body">

                    {{ __('W związku z łamaniem regulaminu to konto zostało zablokowane') }}

                </div>
                <div class="col-md-8 offset-md-4">
                    <a href="{{ route('login') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form2').submit();"><button type="submit" class="btn btn-primary" ><i class="fa fa-forward fa-fw" aria-hidden="true"></i> <span>Wyloguj</span></button></a> <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
