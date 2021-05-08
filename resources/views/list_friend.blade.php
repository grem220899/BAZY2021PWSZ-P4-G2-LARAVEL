@extends('layouts.app')

@section('content')
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
            <div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
            <p style="margin-bottom: 0px"> {{auth()->user()->email}} </p>
            <p style="margin-bottom: 0px"> {{auth()->user()->name}} </p>
            <p style="margin-bottom: 0px"> {{auth()->user()->surname}} </p>
            <p style="margin-bottom: 0px"> {{auth()->user()->nick}} </p>
            </div>
        </div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" class="dodajZnajomego" placeholder="Szukaj znajomego..." />
		</div>
        <div id="addfriend"style="display: none;">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            @csrf
			<input id="dodajZnajomegoInput" type="text" class="dodajZnajomego" placeholder="Dodaj znajomego..." /><button id ="dodajZnajomegoBtn" class="dodawanie">Dodaj</button>
		</div>
        <div id="contacts">
			<ul id="listaUzytkownikow" style="padding-left: 0px; list-style: none;">
                @foreach ($friend_list as $item)
                        <form action="/usun-znajomego" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}"><button type="submit">Usun</button>
                            
                        </form>
                    
				<li class="contact friendelement">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div>
					</div>
				</li>
                @endforeach
                @foreach ($waiting as $item)
                        <form action="/usun-znajomego" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit">Usun</button>
                        </form>
                    
				<li class="contact sendelement">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div>
					</div>
				</li>
                @endforeach
                @foreach ($waiting2 as $item)
                <form style="display: none;" action="/akceptuj-zaproszenie" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <button type="submit">Akceptuj</button>
                </form>
                    
				<li class="contact waitingelement">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div>
					</div>
				</li>
                @endforeach
            </ul>
        </div>
        <div id="bottom-bar">
			<button id="friendlistBtn"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Lista znajomych</span></button>

			<button id="sendlistBtn"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Lista wysłanych</span></button>

            <button id="waitingsBtn"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Lista oczekujących</span></button>
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form2').submit();"><button id="logoutBtn" ><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Wyloguj</span></button></a> <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
		</div>
    </div>
    <div class="content">
		<div class="contact-profile">
			<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p>Harvey Specter</p>
		</div>
		<div class="messages">
			<ul>
				<li class="sent">
					<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
					<p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
				</li>
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>When you're backed against the wall, break the god damn thing down.</p>
				</li>
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>Excuses don't win championships.</p>
				</li>
				<li class="sent">
					<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
					<p>Oh yeah, did Michael Jordan tell you that?</p>
				</li>
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>No, I told him that.</p>
				</li>
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>What are your choices when someone puts a gun to your head?</p>
				</li>
				<li class="sent">
					<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
					<p>What are you talking about? You do what they say or they shoot you.</p>
				</li>
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
				</li>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Napisz wiadomość..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true">P</i>
			<button class="submit">Wyślij<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
<div class="container" style="display: none;">
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
</div>

@endsection


