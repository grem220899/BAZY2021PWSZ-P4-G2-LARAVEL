@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Potwierdź swój adres email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nowy link aktywacyjny został wysłany na Twój adres email.') }}
                        </div>
                    @endif

                    {{ __('Przed kontynuowaniem sprawdź, czy w e-mailu nie ma linku weryfikacyjnego .') }}
                    {{ __('Jeśli email z linkiem nie został dostarczony') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('wciśnij tutaj aby przesłać kolejny link') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
