@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista znajomych') }}</div>

                <div class="card-body">
                    @foreach ($friend_list as $item)
                        {{$item->email}}
                        <form action="/usun-znajomego" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit">Usun</button>
                        </form><br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dodaj znajomego') }}</div>

                <div class="card-body">
                    <form action="/dodaj-znajomych" method="POST">
                        @csrf
                        <input type="text" placeholder="Adres Email" name="email">
                        <button type="submit">Dodaj</button>
                        @if ($error)
                            <div class="alert-danger">
                                {{$error}}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista wysłanych zaproszeń') }}</div>

                <div class="card-body">
                    @foreach ($waiting as $item)
                        {{$item->email}}<br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista oczekujących zaproszeń') }}</div>

                <div class="card-body">
                    @foreach ($waiting2 as $item)
                        {{$item->email}}
                        <form action="/akceptuj-zaproszenie" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit">Akceptuj</button>
                        </form><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
