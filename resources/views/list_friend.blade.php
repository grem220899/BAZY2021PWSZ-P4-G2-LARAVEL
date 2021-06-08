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
            @csrf
			<input id="dodajZnajomegoInput" type="text" class="dodajZnajomego" placeholder="Dodaj znajomego..." /><button id ="dodajZnajomegoBtn" class="dodawanie">Dodaj</button>
		</div>
        <div id="contacts">
			<ul id="listaUzytkownikow" style="padding-left: 0px; list-style: none;">
                @foreach ($friend_list as $item)


				<li class="contact friendelement" data-id="{{$item->id}}">
					<div class="wrap">
                        <span class="contact-status offline" id="contact-status{{$item->id}}"></span>
						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
                            <p class="name">
                                {{$item->name}} {{$item->surname}}
                                </p>
						</div>

					</div>
				</li>
                @endforeach
                {{-- Lista wysłanych --}}
                @foreach ($waiting as $item)


				<li class="contact sendelement">
					<div class="wrap">

						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">{{$item->name}} {{$item->surname}}</p>
						</div>
                        <button  data-id="{{$item->id}}" class="dodawanie usun" >Usuń</button>

					</div>
				</li>
                @endforeach
                {{-- Lista oczekujących --}}
                @foreach ($waiting2 as $item)


				<li class="contact waitingelement">
					<div class="wrap">

						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">
                                {{$item->name}} {{$item->surname}}
                                <button  data-id="{{$item->id}}" class="dodawanie akceptuj" style="position: static;padding:5px;background:green;">✓</button>
                                <button  data-id="{{$item->id}}" class="dodawanie usun" style="position: static;padding:5px;background:red;">X</button>

                            </p>


					</div>
				</li>
                @endforeach
                {{-- Lista zbanowanych --}}
                @foreach ($waiting3 as $item)


				<li class="contact bannedelement">
					<div class="wrap">

						<img src="/uploads/avatars/{{$item->avatar}}" alt="" />
						<div class="meta">
							<p class="name">
                                {{$item->name}} {{$item->surname}}
                                <button  data-id="{{$item->id}}" class="dodawanie odbanuj" >Odbanuj</button>
                            </p>
					</div>
				</li>
                @endforeach
                @foreach ($grupy['nazwy'] as $item)
                <li class="contact grupyelement" data-nazwa="{{$item['nazwa']}}" data-id="{{$item['id']}}" data-czlonkowie="@foreach ($grupy['czlonkowie'][$item['nazwa']] as $item2){{$item2->id}},@endforeach">
					<div class="wrap">

						<img src="/uploads/avatars/grupyavatar.png" alt="" />
						<div class="meta">
							<p class="name">
                                {{$item['nazwa']}}


                            </p>


					</div>
				</li>
                @endforeach
            </ul>
        </div>
        <div id="bottom-bar">
			<button id="friendlistBtn"><i class="fa fa-user fa-fw" aria-hidden="true"></i> <span>Znajomi</span></button>

			<button id="sendlistBtn"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Wysłane</span></button>

            <button id="waitingsBtn"><i class="fa fa-spinner fa-fw" aria-hidden="true"></i> <span>Oczekujące</span></button>

            <button id="bannedBtn"><i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span>Zbanowani</span></button>

            <button data-toggle="modal" data-target="#utworzGrupeBtn" id=""><i class="fa fa-users fa-fw" aria-hidden="true"></i> <span>Utwórz grupę</span></button>

            <div class="modal fade" id="utworzGrupeBtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="
            background: #2c3e50;">
                      <h5 class="modal-title" id="exampleModalLongTitle">Utwórz grupę</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4x">
                                    <input placeholder="Nazwa grupy" type="text" class="podajDane" name="nazwa_grupy" id="nazwa_nowej_grupy" required  autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4x">
                                    <ul style="padding-left:0px;">
                                    @foreach ($friend_list as $item)
                                        <li
                                        style="background: #2c3e50;margin-bottom:2px;">
                                            <input type="checkbox" class="czlonkowie" name="czlonkowie[]" value="{{$item->id}}"> {{$item->name}} {{$item->surname}} ({{$item->nick}})
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="utworz_grupe">
                                        {{ __('Utwórz grupę') }}
                                    </button>
                                </div>
                            </div>
                    </div>
                  </div>
                </div>
              </div>

            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form2').submit();"><button id="logoutBtn" ><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> <span>Wyloguj</span></button></a> <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
		</div>
    </div>
    <div class="content" id="messageContent" style="display:none;">
		<div class="contact-profile">
			<img id="avatarOdbiorcy" src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
			<p id="nazwaOdbiorcy" style="padding: 5px"></p>
<div class="uzytkownicy">
            <button id="pokazWiecej" class="btn btn-primary"data-strona="1" style="position: static;padding:10px;">Pokaż więcej</button>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="position: static;padding:10px;">
                Zbanuj
              </button>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Banowanie</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Jesteś pewny że chcesz zbanować tego użytkownika?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal" style="position: static;padding:10px;">Anuluj</button>
                      <button type="button" id="zbanujBtn" data-id="0" class="zbanuj btn btn-primary" style="position: static;padding:10px;">Zbanuj</button>
                    </div>
                  </div>
                </div>
              </div>

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="position: static;padding:10px;">
                Usuń
              </button>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Usuwanie</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Jesteś pewny że chcesz usunąć tego użytkownika?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal" style="position: static;padding:10px;">Nie</button>
                      <button type="button" id="usunBtn" data-id="0" class="usun btn btn-primary" style="position: static;padding:10px;">Tak</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <div class="grupowe">
                <button type="button" id="usunGrp" data-id="0" class="usun btn btn-primary" style="position: static;padding:10px;">Usuń członka grupy</button>
              </div>


            {{-- <button id="zbanujBtn" data-id="0" class="zbanuj btn btn-primary" style="position: static;padding:10px;">Zbanuj</button> --}}
            {{-- <button id="usunBtn" data-id="0" class="usun btn btn-primary" style="position: static;padding:10px;">Usuń</button> --}}

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
			<i class="fa fa-paperclip attachment" aria-hidden="true" id="dodajPlik"></i>
			<button class="submit" id="wyslijWiadomosc"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('scripts')
    <script>
        $(function () {
            $("#utworz_grupe").click(function () {
                let url = "{{ route('utworz-grupe') }}"
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("_token", token)
                fd.append("nazwa_grupy", $("#nazwa_nowej_grupy").val())
                var czlonkowie=[]
                for(i=0;i<$(".czlonkowie:checked").length;i++){
                    czlonkowie.push($(".czlonkowie:checked").eq(i).val())
                }
                console.log(czlonkowie)
                fd.append("czlonkowie", czlonkowie)
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                        location.reload()
                    },
                    error: function (response) {

                        console.log(response)
                    }
                })
            })
    let klucz = null;
    let wulgaryzmy = "{{ $wulgaryzmy }}";
    wulgaryzmy = wulgaryzmy.replaceAll("&quot;", '"')
    wulgaryzmy = JSON.parse(wulgaryzmy);
    let zamienniki = "{{ $zamienniki }}";
    zamienniki = zamienniki.replaceAll("&quot;", '"')
    zamienniki = JSON.parse(zamienniki);
    let user_id = "{{ auth()->user()->id }}";
    let friendId = null
    let typCzat=null
    let hashCzatu=null
    $(".friendelement").click(function () {
        $("#messages").html("")
        let url = "{{ route('message.reciveMessage') }}"
        friendId = parseInt($(this).attr("data-id"))
        typCzat="user"
        $("#zbanujBtn").attr("data-id",friendId)
        $("#usunBtn").attr("data-id",friendId)
        let fd = new FormData();
        let token = "{{ csrf_token() }}"
        fd.append("_token", token)
        fd.append("receiver_id", friendId)
        fd.append("strona", 0)
        fd.append("typCzat", typCzat)
        $("#pokazWiecej").attr("data-strona",1)
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                console.log(response)
                $("#messageContent").css("display", "block")
                $("#nazwaOdbiorcy").html(response.friendInfo[0].name + " " + response.friendInfo[0].surname)
                $("#avatarOdbiorcy").attr('src', '/uploads/avatars/' + response.friendInfo[0].avatar)
                klucz = response.klucz;
                wyswietlWiadomosci(response)
                $(".messages").scrollTop(10000);

                if(typCzat=='user'){
                    if(friendId<user_id){
                        hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+" "+friendId+" {{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id)
                    }else{
                        hashCzatu=CryptoJS.MD5("{{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id+" "+$("#nazwaOdbiorcy").html()+" "+friendId)
                    }
                }else{
                    hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+friendId)
                }
            },
            error: function (response) {

                console.log(response)
            }
        })
    })
    $(".grupyelement").click(function () {
        $("#messages").html("")
        let url = "{{ route('message.reciveMessage') }}"
        friendId = parseInt($(this).attr("data-id"))
        typCzat="grupa"
        $("#usunGrp").attr("data-id",friendId)
        let fd = new FormData();
        let grupa=$(this).attr("data-nazwa")
        let token = "{{ csrf_token() }}"
        fd.append("_token", token)
        fd.append("receiver_id", friendId)
        fd.append("strona", 0)
        fd.append("nazwa_grupy", grupa)
        fd.append("typCzat", typCzat)
        fd.append("czlonkowie",$(this).attr("data-czlonkowie"))
        $("#pokazWiecej").attr("data-strona",1)
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                console.log(response)
                $("#messageContent").css("display", "block")
                $("#nazwaOdbiorcy").html(grupa)
                $("#avatarOdbiorcy").attr('src', '/uploads/avatars/grupyavatar.png')
                klucz = response.klucz;
                wyswietlWiadomosci2(response)
                $(".messages").scrollTop(10000);

                if(typCzat=='user'){
                    if(friendId<user_id){
                        hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+" "+friendId+" {{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id)
                    }else{
                        hashCzatu=CryptoJS.MD5("{{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id+" "+$("#nazwaOdbiorcy").html()+" "+friendId)
                    }
                }else{
                    hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+friendId)
                }
            },
            error: function (response) {

                console.log(response)
            }
        })
    })
    $("#pokazWiecej").click(function () {
        let url = "{{ route('message.reciveMessage') }}"
        let fd = new FormData();
        let token = "{{ csrf_token() }}"
        fd.append("_token", token)
        fd.append("receiver_id", friendId)
        fd.append("typCzat", typCzat)
        fd.append("strona", $(this).attr("data-strona"))
        $(this).attr("data-strona",parseInt($(this).attr("data-strona"))+1)
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                console.log(response)
                $("#messageContent").css("display", "block")
                $("#nazwaOdbiorcy").html(response.friendInfo[0].name + " " + response.friendInfo[0].surname)
                $("#avatarOdbiorcy").attr('src', '/uploads/avatars/' + response.friendInfo[0].avatar)
                klucz = response.klucz;
                wyswietlWiadomosci(response)

            },
            error: function (response) {

                console.log(response)
            }
        })
    })
    function wyswietlWiadomosci(response){

        for (i = 0; i < response.messages.length; i++) {
            let wiadomosci = ``
            if (response.messages[i].odbiorca_id == friendId) {

                if (response.messages[i].wiadomosc != null)
                    wiadomosci += `
                <li class="sent">
                    <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                    <p class="wiadomoscTresc" data-szyfr="1">` + response.messages[i].wiadomosc + `</p>
                </li>`;
                if (response.messages[i].plik_id != undefined)
                    for (j = 0; j < response.messages[i].plik_id.length; j++)
                        if (response.pliki[response.messages[i].plik_id[j]] != "") {
                            wiadomosci+=appendFileToSender(response.pliki[response.messages[i].plik_id[j]].nazwa,0)
                        }

            } else {

                if (response.messages[i].wiadomosc != null)
                    wiadomosci += `
                <li class="replies">
                    <img src="/uploads/avatars/` + response.friendInfo[0].avatar + `" alt="" />
                    <p class="wiadomoscTresc" data-szyfr="1">` + response.messages[i].wiadomosc + `</p>
                </li>
                `

                if (response.messages[i].plik_id != undefined)
                    for (j = 0; j < response.messages[i].plik_id.length; j++)
                        if (response.pliki[response.messages[i].plik_id[j]] != "")
                            wiadomosci+=appendFileToReceiver(response.pliki[response.messages[i].plik_id[j]].nazwa, response.friendInfo[0].avatar,0)
            }
            $("#messages").prepend(wiadomosci)
        }
    }
    function wyswietlWiadomosci2(response){

for (i = 0; i < response.messages.length; i++) {
    let wiadomosci = ``
    if (response.messages[i].nadawca_id == user_id) {

        if (response.messages[i].wiadomosc != null)
            wiadomosci += `
        <li class="sent">
            <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + response.messages[i].wiadomosc + `</p>
        </li>`;
        if (response.messages[i].plik_id != undefined)
            for (j = 0; j < response.messages[i].plik_id.length; j++)
                if (response.pliki[response.messages[i].plik_id[j]] != "") {
                    wiadomosci+=appendFileToSender(response.pliki[response.messages[i].plik_id[j]].nazwa,0)
                }

    } else {

        if (response.messages[i].wiadomosc != null)
            wiadomosci += `
        <li class="replies">
            <img src="/uploads/avatars/`+response.avatars[response.messages[i].nadawca_id]+`" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + response.messages[i].wiadomosc + `</p>
        </li>
        `

        if (response.messages[i].plik_id != undefined)
            for (j = 0; j < response.messages[i].plik_id.length; j++)
                if (response.pliki[response.messages[i].plik_id[j]] != "")
                    wiadomosci+=appendFileToReceiver(response.pliki[response.messages[i].plik_id[j]].nazwa, response.avatars[response.messages[i].nadawca_id],0)
    }
    $("#messages").prepend(wiadomosci)
}
}
    let ip_address = 'http://grzesiekkomp.asuscomm.com';
    // let ip_address = 'http://localhost';
    // let ip_address = 'http://projektkt.pl';
    let socket_port = '3000';

    const socket = io(ip_address + ':' + socket_port, {
        transports: ['websocket', 'polling', 'flashsocket'],
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
        for (i = 0; i < wulgaryzmy.length; i++) {
            var r=new RegExp(wulgaryzmy[i],"i")
            message=message.replace(r, " {" + zamienniki[Math.floor(Math.random() * (zamienniki.length - 1))] + "} ")
        }
        if(typCzat=='user'){
            if(friendId<user_id){
                hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+" "+friendId+" {{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id)
            }else{
                hashCzatu=CryptoJS.MD5("{{ auth()->user()->name }} "+"{{ auth()->user()->surname }} "+user_id+" "+$("#nazwaOdbiorcy").html()+" "+friendId)
            }
        }else{
            hashCzatu=CryptoJS.MD5($("#nazwaOdbiorcy").html()+friendId)
        }
        fd.append("hashCzatu", hashCzatu)
            let zaszyfrowanaWiadomosc = ""
        if(message!="")
            zaszyfrowanaWiadomosc = CryptoJS.AES.encrypt(message, klucz).toString()

        fd.append("message", zaszyfrowanaWiadomosc)
        fd.append("_token", token)
        fd.append("receiver_id", friendId)
        fd.append("typCzat",typCzat)
        let pliki = [];
        for (i = 0; i < $("#podglad").children().length; i++) {
            pliki[i] = $("#podglad").children().eq(i).attr("data-nazwa")
        }
        fd.append("pliki", pliki)
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
                    socket.emit('message', response);
                    $("#podglad").html("")
                    $(".messages").scrollTop(10000);
                }
            },
            error: function (response) {

                console.log(response)
            }
        })
    }

    function appendMessageToSender(message) {
        var wiadomosci = `

        <li class="sent">
            <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + message.data.wiadomosc + `</p>
        </li>`;
        $("#messages").append(wiadomosci)
    }

    function appendFileToSender(message,opcja=1) {
        let plik = message.split('.')
        let img = ['jpg', 'jpeg', 'png', 'gif']
        var wiadomosci = ``
        if (img.includes(plik[plik.length - 1])) {
            wiadomosci = `

        <li class="sent">
            <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt=""  />
            <p><img src="/uploads/pliki/` + message + `" style="width: 100%;height: auto;
border-radius: 0;"></p>
        </li>`;
        } else {
            wiadomosci = `

            <li class="sent">
                <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                <p><a href="{{asset('storage/` + message + `')}}" target="_blank" download>` + message + `</a></p>
            </li>`;
        }
        if(opcja)
            $("#messages").append(wiadomosci)
        else
            return wiadomosci
    }

    function appendFileToReceiver(message, avatar,opcja=1) {
        let plik = message.split('.')
        let img = ['jpg', 'jpeg', 'png', 'gif']
        var wiadomosci = ``
        if (img.includes(plik[plik.length - 1])) {
            wiadomosci = `

        <li class="replies">
            <img src="/uploads/avatars/` + avatar + `" alt="" />
            <p><img src="/uploads/pliki/` + message + `" style="width: 100%;height: auto;
border-radius: 0;"></p>
        </li>`;
        } else {
            wiadomosci = `

            <li class="replies">
                <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                <p><a href="{{asset('storage/` + message + `')}}" target="_blank" download>` + message + `</a></p>
            </li>`;
        }
        if(opcja)
            $("#messages").append(wiadomosci)
        else
            return wiadomosci
    }
    function appendFile2(message, avatar,opcja=1,klasa) {
        let plik = message.split('.')
        let img = ['jpg', 'jpeg', 'png', 'gif']
        var wiadomosci = ``
        if (img.includes(plik[plik.length - 1])) {
            wiadomosci = `

        <li class="`+klasa+`">
            <img src="/uploads/avatars/` + avatar + `" alt="" />
            <p><img src="/uploads/pliki/` + message + `" style="width: 100%;height: auto;
border-radius: 0;"></p>
        </li>`;
        } else {
            wiadomosci = `

            <li class="`+klasa+`">
                <img src="/uploads/avatars/{{auth()->user()->avatar}}" alt="" />
                <p><a href="{{asset('storage/` + message + `')}}" target="_blank" download>` + message + `</a></p>
            </li>`;
        }
        if(opcja)
            $("#messages").append(wiadomosci)
        else
            return wiadomosci
    }
    function appendMessageToReceiver(message) {
        var wiadomosci = `

        <li class="replies">
            <img src="/uploads/avatars/` + message.avatar + `" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + message.data.wiadomosc + `</p>
        </li>`;
        console.log(message)
        $("#messages").append(wiadomosci)
    }
    function appendMessageNew(message) {
        if(message.data.nadawca_id==user_id){
        var wiadomosci = `

        <li class="sent">
            <img src="/uploads/avatars/` + message.avatar + `" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + message.data.wiadomosc + `</p>
        </li>`;
        }else{
            var wiadomosci = `

        <li class="replies">
            <img src="/uploads/avatars/` + message.avatar + `" alt="" />
            <p class="wiadomoscTresc" data-szyfr="1">` + message.data.wiadomosc + `</p>
        </li>`;
        }
        console.log(message)
        $("#messages").append(wiadomosci)
    }
    socket.on("newMessage", function (message) {
        if(message.data.hashCzatu==hashCzatu){
                if (message.data.wiadomosc != null)
                    appendMessageNew(message);
                for (i = 0; i < message.pliki.length; i++)
                    if (message.pliki[i] != "")
                        if(message.data.nadawca_id==user_id)
                            appendFile2(message.pliki[i], message.avatar,1,"sent")
                        else
                            appendFile2(message.pliki[i], message.avatar,1,"replies")

                $(".messages").scrollTop(10000);
        }
    })
    socket.on("updateUserStatus",function(users){
        console.log(users)
        $(".contact-status").removeClass("online")
        $(".contact-status").addClass("offline")
        users.forEach(function(e,i){
            if(e!=0 && e!=null){
                $("#contact-status"+i).removeClass("offline")
                $("#contact-status"+i).addClass("online")
            }
        })
    })
    socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message) {
        if (message.data.wiadomosc != null){
            if(message.data.typCzat=='user'){
            appendMessageToReceiver(message);
            $(".messages").scrollTop(10000);
            }else{

            }
        }
    });
    $(document).on('click', ".wiadomoscTresc", function () {
        console.log($(this).attr("data-szyfr"))
        console.log($(this).attr("data-szyfr") == "1")
        if ($(this).attr("data-szyfr") == "1") {
            var odszyfrowana = CryptoJS.AES.decrypt($(this).html(), klucz);
            $(this).html(odszyfrowana.toString(CryptoJS.enc.Utf8))
            $(this).attr("data-szyfr", "0")
        }

    })
})

    </script>
@endpush

