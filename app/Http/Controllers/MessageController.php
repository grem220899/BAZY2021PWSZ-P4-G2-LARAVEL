<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\PrivateMessageEvent;
use App\Events\NewChatMessage;

class MessageController extends Controller
{
    public function reciveMessage()
    {
        $userId=(int)$_POST['receiver_id'];
        $friendInfo = DB::select("select * from users where id=" . $userId);
        $myInfo = DB::select("select * from users where id=" . Auth::id());
        $this->data['userId'] = $userId;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['messages']=Message::whereIn('nadawca_id',[(int)$userId,Auth::id()])->whereIn('odbiorca_id',[(int)$userId,Auth::id()])->get();

        echo json_encode($this->data);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required',
        ]);
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;
        Message::create([
            'wiadomosc' => $request->message,
            'odbiorca_id' => (int)$receiver_id,
            'nadawca_id' => $sender_id,
            'typ_odbiorcy'=>'user'
        ]);
        $data = array(
            'nadawca_id' => $sender_id,
            'odbiorca_id' => $receiver_id,
            'wiadomosc' => $request->message,
            'data'=>date("Y-m-d H:i:s")
        );
        // event(new PrivateMessageEvent($data));
        broadcast(new PrivateMessageEvent($data))->toOthers();
        return response()->json([
            'data'=>$data,
            'success'=>true,
        ]);

        // $message=new Message;
        // $message->message=$request->message;
        // if($message->save()){
        //     // $message->users()->attach()
        // }
    }
}
