<?php

namespace App\Http\Controllers;

use App\Events\PrivateMessageEvent;
use App\Models\Files;
use App\Models\Message;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function reciveMessage()
    {
        $userId = (int) $_POST['receiver_id'];
        if ('user' == $_POST['typCzat']) {
            $friendInfo = DB::select("select * from users where id=" . $userId);
            $myInfo = DB::select("select * from users where id=" . Auth::id());
            $this->data['friendInfo'] = $friendInfo;
            $this->data['myInfo'] = $myInfo;
        }
        $this->data['userId'] = $userId;
        if ('user' == $_POST['typCzat']) {
            $this->data['messages'] = Message::whereIn('nadawca_id', [(int) $userId, Auth::id()])->whereIn('odbiorca_id', [(int) $userId, Auth::id()])->where("typ_odbiorcy", $_POST['typCzat'])->orderBy('created_at', 'desc')->skip((int) $_POST['strona'] * 20)->take(20)->get();
        } else {
            $_POST['czlonkowie']=explode(",",$_POST['czlonkowie']);
            $czlonkowie=[];
            foreach($_POST['czlonkowie'] as $c){
                $czlonkowie[]=(int)$c;
            }
            $this->data['messages'] = Message::whereIn('nadawca_id', $czlonkowie)->whereIn('odbiorca_id', [(int) $userId])->where("typ_odbiorcy", $_POST['typCzat'])->orderBy('created_at', 'desc')->skip((int) $_POST['strona'] * 20)->take(20)->get();
            $avatars=DB::select("SELECT id,avatar FROM users WHERE id IN(".implode(',',$czlonkowie).")");
            $avatars_arr=[];
            foreach($avatars as $a){
                $avatars_arr[$a->id]=$a->avatar;
            }
            $this->data['avatars']=$avatars_arr;
        }
        $filesId = [];
        foreach ($this->data['messages'] as $mess) {
            if (!empty($mess['plik_id'])) {
                if (!is_array($mess['plik_id'])) {
                    $filesId[] = $mess['plik_id'];
                } else {
                    foreach ($mess['plik_id'] as $p) {
                        $filesId[] = $p;
                    }
                }
            }

        }
        $this->data['pliki'] = $files = Files::whereIn('_id', $filesId)->get();
        $files2 = [];
        foreach ($files as $f) {
            $files2[$f['_id']] = $f;
        }

        $this->data['pliki'] = $files2;
        if ('user' == $_POST['typCzat']) {
            if ($friendInfo[0]->id < $myInfo[0]->id) {
                $this->data['klucz'] = md5($myInfo[0]->email . $friendInfo[0]->email);
            } else {
                $this->data['klucz'] = md5($friendInfo[0]->email . $myInfo[0]->email);
            }
        } else {
            $owner = DB::select("select * from group_name  where name='" . $_POST['nazwa_grupy'] . "'");
            $this->data['klucz'] = md5($owner[0]->id.$owner[0]->name);
        }

        echo json_encode($this->data);
    }

    public function sendMessage(Request $request)
    {
        // echo json_encode($_POST);
        // die();
        $request->validate([
            'receiver_id' => 'required',
        ]);
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;
        $_POST['pliki'] = explode(",", $_POST['pliki']);
        if (!empty($_POST['pliki'][0])) {
            $plikiIdArr = [];
            $pliki = Files::whereIn("nazwa", $_POST['pliki'])->get();
            foreach ($pliki as $p) {
                $plikiIdArr[] = $p['_id'];
                // var_dump($p['_id']);
            }
            // var_dump($plikiIdArr);
            // die();

            Message::create([
                'wiadomosc' => $request->message,
                'odbiorca_id' => (int) $receiver_id,
                'nadawca_id' => $sender_id,
                'typ_odbiorcy' => $_POST['typCzat'],
                'plik_id' => $plikiIdArr,
            ]);
        } else {
            Message::create([
                'wiadomosc' => $request->message,
                'odbiorca_id' => (int) $receiver_id,
                'nadawca_id' => $sender_id,
                'typ_odbiorcy' => $_POST['typCzat'],
            ]);
        }

        $friendInfo = DB::select("select * from users where id=" . $sender_id);
        $data = array(
            'nadawca_id' => $sender_id,
            'odbiorca_id' => $receiver_id,
            'wiadomosc' => $request->message,
            'avatar' => $friendInfo[0]->avatar,
            'data' => date("Y-m-d H:i:s"),
            'typCzat' => $_POST['typCzat'],
            'hashCzatu' => $_POST['hashCzatu'],
        );
        // event(new PrivateMessageEvent($data));
        broadcast(new PrivateMessageEvent($data))->toOthers();
        return response()->json([
            'data' => $data,
            'success' => true,
            'avatar' => $friendInfo[0]->avatar,
            'pliki' => $_POST['pliki'],
        ]);

        // $message=new Message;
        // $message->message=$request->message;
        // if($message->save()){
        //     // $message->users()->attach()
        // }
    }
    public function dodajPlik()
    {
        $roz = explode('.', $_FILES['file']['name']);
            $nazwa = uniqid();
            Storage::putFileAs('public/',$_FILES['file']['tmp_name'],$nazwa . '.' . $_FILES["file"]['name']);

            echo json_encode(['plik' => '<a href="'.asset('storage/'   .$nazwa . '.' .$_FILES["file"]['name']) . '" data-nazwa="' . $nazwa . '.' .$_FILES["file"]['name'] . '"  target="_blank" download>' . $nazwa . '.' .$_FILES["file"]['name'] . '</a>']);
            Files::create([
                'nazwa' => $nazwa . '.' .$_FILES["file"]['name'],
                'rozszerzenie' => $roz[count($roz) - 1],
                'przeznaczenie' => 'wiadomosc',
                'uzytkownik_id' => Auth::id(),
            ]);

    }
}
