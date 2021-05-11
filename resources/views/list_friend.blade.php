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

				<li class="contact friendelement" data-id="{{$item->id}}">
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
    <div class="content" id="messageContent" style="display:none;">
		<div class="contact-profile">
			<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p id="nazwaOdbiorcy">Harvey Specter</p>
		</div>
		<div class="messages">
			<ul id="messages">

			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Napisz wiadomość..." id="trescWiadomosci"/>
			<i class="fa fa-paperclip attachment" aria-hidden="true">P</i>
			<button class="submit" id="wyslijWiadomosc">Wyślij<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
@push('scripts')
    <script>
        $(function(){
            let user_id = "{{ auth()->user()->id }}";
            let friendId=null
            $(".friendelement").click(function(){
                let url = "{{ route('message.reciveMessage') }}"
                friendId=parseInt($(this).attr("data-id"))
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("_token", token)
                fd.append("receiver_id", friendId)

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                        $("#messageContent").css("display","block")
                        $("#nazwaOdbiorcy").html(response.friendInfo[0].name+" "+response.friendInfo[0].surname)
                        let wiadomosci=``
                        for(i=0;i<response.messages.length;i++){
                            if(response.messages[i].odbiorca_id==friendId)
                            wiadomosci+=`

				<li class="sent">
					<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
					<p>`+response.messages[i].wiadomosc+`</p>
				</li>`;
                else
                wiadomosci+=`
				<li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
					<p>`+response.messages[i].wiadomosc+`</p>
				</li>
                `
                $("#messages").html(wiadomosci)
                        }

                    },
                    error:function(response){

                        console.log(response)
                    }
                })
            })

            let ip_address = 'http://grzesiekkomp.asuscomm.com';
            let socket_port = '3000';
            // let ip_address = '127.0.0.1';
            // let socket_port = '3000';
            const socket=io(ip_address+ ':' + socket_port,{
                transports:['websocket','polling','flashsocket'],
            });
            socket.on('connect', function () {
                socket.emit('user_connected', user_id);
            });
            $("#wyslijWiadomosc").click(function () {
                sendMessage($("#trescWiadomosci").val())
                $("#trescWiadomosci").val("")
            })
            $("#trescWiadomosci").keypress(function (e) {
                let message = $(this).val();
                if (e.which === 13 && !e.shiftKey) {
                    $("#trescWiadomosci").val("")
                    sendMessage(message)
                    return false;
                }
            })

            function sendMessage(message) {
                let url = "{{ route('message.sendMessage') }}"
                let form = $(this)
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("message", message)
                fd.append("_token", token)
                fd.append("receiver_id", friendId)

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                            console.log(response)
                        if (response.success) {
                            console.log(response)
                            appendMessageToSender(response)
                            socket.emit('message', response);
                        }
                    },
                    error:function(response){

                        console.log(response)
                    }
                })
            }
            function appendMessageToSender(message){
                var wiadomosci=`

                <li class="sent">
                    <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                    <p>`+message.data.wiadomosc+`</p>
                </li>`;
                $("#messages").append(wiadomosci)
            }
            function appendMessageToReceiver(message){
                var wiadomosci=`

                <li class="replies">
					<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>`+message.data.wiadomosc+`</p>
                </li>`;
                console.log(message)
                $("#messages").append(wiadomosci)
            }
            socket.on("newMessage",function(message){
                if(message.data.nadawca_id==friendId && message.data.odbiorca_id==user_id)
                    appendMessageToReceiver(message);
            })
            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message)
            {
               appendMessageToReceiver(message);
            });
        })
    </script>
@endpush

