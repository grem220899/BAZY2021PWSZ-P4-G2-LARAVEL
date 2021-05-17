@extends('layouts.app')

@section('content')
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
            <div class="wrap">
                <input type="file" name="avatar_file" id="avatar_file" style="display: none" accept="image/*">
				<img id="profile-img" src="/uploads/avatars/{{auth()->user()->avatar}}" class="online" alt="" />

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


				<li class="contact friendelement" data-id="{{$item->id}}">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div><form action="/usun-znajomego" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}"><button type="submit">Usun</button>

                        </form>
					</div>
				</li>
                @endforeach
                @foreach ($waiting as $item)


				<li class="contact sendelement">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div><form action="/usun-znajomego" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit">Usun</button>
                        </form>
					</div>
				</li>
                @endforeach
                @foreach ($waiting2 as $item)


				<li class="contact waitingelement">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div><form style="display: none;" action="/akceptuj-zaproszenie" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <button type="submit">Akceptuj</button>
                </form>
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
			<img id="avatarOdbiorcy" src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
			<p id="nazwaOdbiorcy"></p>
		</div>
		<div class="messages">
			<ul id="messages">

			</ul>
		</div>
		<div class="message-input">
            <div id="podglad"></div>
			<div class="wrap">
			<input type="text" placeholder="Napisz wiadomość..." id="trescWiadomosci"/>
            <input type="file" name="file" id="plikWiadomosci" style="display: none">
			<i class="fa fa-paperclip attachment" aria-hidden="true" id="dodajPlik">P</i>
			<button class="submit" id="wyslijWiadomosc">Wyślij<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
                        $("#avatarOdbiorcy").attr('src','/uploads/avatars/'+response.friendInfo[0].avatar)

                        for(i=0;i<response.messages.length;i++){
                            let wiadomosci=``
                                if(response.messages[i].odbiorca_id==friendId){

                            if(response.messages[i].wiadomosc!=null)
                                    wiadomosci+=`
                                <li class="sent">
                                    <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                                    <p>`+response.messages[i].wiadomosc+`</p>
                                </li>`;
                                if(response.messages[i].plik_id!=undefined)
                            for(j=0;j<response.messages[i].plik_id.length;j++)
                                if(response.pliki[response.messages[i].plik_id[j]]!=""){
                                    appendFileToSender(response.pliki[response.messages[i].plik_id[j]].nazwa)
                                }

                            }else{

                            if(response.messages[i].wiadomosc!=null)
                                    wiadomosci+=`
                                <li class="replies">
                                    <img src="/uploads/avatars/`+response.friendInfo[0].avatar+`" alt="" />
                                    <p>`+response.messages[i].wiadomosc+`</p>
                                </li>
                                `

                                if(response.messages[i].plik_id!=undefined)
                                    for(j=0;j<response.messages[i].plik_id.length;j++)
                                        if(response.pliki[response.messages[i].plik_id[j]]!="")
                                            appendFileToReceiver(response.pliki[response.messages[i].plik_id[j]].nazwa,response.friendInfo[0].avatar)
                }
                    $("#messages").append(wiadomosci)
                        }

                    },
                    error:function(response){

                        console.log(response)
                    }
                })
            })

            // let ip_address = 'http://grzesiekkomp.asuscomm.com';
            // let socket_port = '3000';
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
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
                let pliki=[];
                for(i=0;i<$("#podglad").children().length;i++){
                    pliki[i]=$("#podglad").children().eq(i).attr("data-nazwa")
                }
                fd.append("pliki",pliki)
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
                            if(response.data.wiadomosc!=null)
                                appendMessageToSender(response)
                            for(i=0;i<response.pliki.length;i++)
                                if(response.pliki[i]!="")
                                    appendFileToSender(response.pliki[i])
                            socket.emit('message', response);
                            $("#podglad").html("")
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
                    <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                    <p>`+message.data.wiadomosc+`</p>
                </li>`;
                $("#messages").append(wiadomosci)
            }
            function appendFileToSender(message){
                let plik=message.split('.')
                let img=['jpg','jpeg','png','gif']
                var wiadomosci=``
                if(img.includes(plik[plik.length-1])){
                wiadomosci=`

                <li class="sent">
                    <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt=""  />
                    <p><img src="/uploads/pliki/`+message+`" style="width: 100%;height: auto;
    border-radius: 0;"></p>
                </li>`;
            }
                else{
                    wiadomosci=`

                    <li class="sent">
                        <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                        <p><a href="/uploads/pliki/`+message+`">`+message+`</a></p>
                    </li>`;
                }
                $("#messages").append(wiadomosci)
            }

            function appendFileToReceiver(message,avatar){
                let plik=message.split('.')
                let img=['jpg','jpeg','png','gif']
                var wiadomosci=``
                if(img.includes(plik[plik.length-1])){
                wiadomosci=`

                <li class="replies">
                    <img src="/uploads/avatars/`+avatar+`" alt="" />
                    <p><img src="/uploads/pliki/`+message+`" style="width: 100%;height: auto;
    border-radius: 0;"></p>
                </li>`;
            }
                else{
                    wiadomosci=`

                    <li class="replies">
                        <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                        <p><a href="/uploads/pliki/`+message+`">`+message+`</a></p>
                    </li>`;
                }
                $("#messages").append(wiadomosci)
            }
            function appendMessageToReceiver(message){
                var wiadomosci=`

                <li class="replies">
					<img src="/uploads/avatars/`+message.avatar+`" alt="" />
                    <p>`+message.data.wiadomosc+`</p>
                </li>`;
                console.log(message)
                $("#messages").append(wiadomosci)
            }
            socket.on("newMessage",function(message){
                if(message.data.nadawca_id==friendId && message.data.odbiorca_id==user_id){
                    if(message.data.wiadomosc!=null)
                        appendMessageToReceiver(message);
                    for(i=0;i<message.pliki.length;i++)
                        if(message.pliki[i]!="")
                            appendFileToReceiver(message.pliki[i],message.avatar)
                }
            })
            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message)
            {
                if(message.data.wiadomosc!=null)
                    appendMessageToReceiver(message);
            });
        })
    </script>
@endpush

