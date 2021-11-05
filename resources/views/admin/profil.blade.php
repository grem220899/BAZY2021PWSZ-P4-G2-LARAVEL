@extends('layouts.app')

@section('content')
    <div id="frame">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap" style="text-align: center;
                        text-transform: uppercase;
                        letter-spacing: 3px;
                        font-size: 21px;
                        font-weight: bold;">
                    Projektkt.pl <br> panel admina
                </div>
            </div>
            <div id="contacts">
                <ul id="listaUzytkownikow" style="padding-left: 0px; list-style: none;">

                </ul>


                <div id="bottom-bar">
                    <a href="/admin"><button><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>
                            <span>Wstecz</span></button></a>


                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form2').submit();"><button id="logoutBtn"><i class="fa fa-sign-out fa-fw"
                                aria-hidden="true"></i> <span>Wyloguj</span></button></a>
                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
            <div class="content" id="wybranaLista" style="overflow:auto">
                <div class="contact-profile">

                    <p id="nazwaListy" style="padding: 5px"></p>


                </div>
                <div class="row">
                    <div class="col-sm-1">
                        <img  src="/uploads/avatars/{{$user[0]->avatar}}" style="width:100%;">
                    </div>
                    <div class="col-sm-11">
                        @foreach ($user[0] as $key=>$item)
                            <strong>{{$key}}:</strong>{{$item}}<br>
                        @endforeach
                    </div>
                </div>
                <div>
                    <table class=" table table-striped- table-bordered table-hover table-checkable responsive"
                        id="datatableWulgaryzmy">
                        <thead>
                            <tr>
                                <th>Id grupy</th>
                                <th>Nazwa grupy</th>
                                <th>Właściciel</th>
                                <th>Członkowie</th>
                                <th>Data utworzenia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupy['nazwy'] as $item)
                                <tr>
                                    <td>{{$item['id']}}</td>
                                    <td>{{$item['nazwa']}}</td>
                                    @foreach ($grupy['czlonkowie'][$item['nazwa']] as $key=>$item2)
                                        @if ($key==0)
                                            <td>
                                                <a href="user?id={{$item2->id}}">{{$item2->id}} {{$item2->email}}</a>
                                            </td>
                                            <td>
                                        @endif
                                        @if ($key>0)
                                            <a href="user?id={{$item2->id}}">{{$item2->id}} {{$item2->email}} {{$item2->od}}</a><br>
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>{{$item['create']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

            </div>
        </div>

    @endsection
    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/datatables.responsive.bootstrap4.min.css') }}">
        <script src="{{ asset('js/datatables.min.js') }}" defer></script>
        <style>

        </style>
        <script>

        </script>
    @endpush
