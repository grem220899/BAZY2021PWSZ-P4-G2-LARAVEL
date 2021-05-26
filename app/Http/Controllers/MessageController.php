<?php

namespace App\Http\Controllers;

use App\Events\PrivateMessageEvent;
use App\Models\Files;
use App\Models\Message;
use App\Models\Wulgaryzmy;
use App\Models\Zamienniki;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function reciveMessage()
    {
        $userId = (int) $_POST['receiver_id'];
        $friendInfo = DB::select("select * from users where id=" . $userId);
        $myInfo = DB::select("select * from users where id=" . Auth::id());
        $this->data['userId'] = $userId;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['messages'] = Message::whereIn('nadawca_id', [(int) $userId, Auth::id()])->whereIn('odbiorca_id', [(int) $userId, Auth::id()])->get();
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
        $this->data['pliki']=$files=Files::whereIn('_id', $filesId)->get();
        $files2=[];
        foreach($files as $f)
            $files2[$f['_id']]=$f;
        $this->data['pliki'] = $files2;
        $this->data['klucz']=md5($friendInfo[0]->email.$myInfo[0]->email);
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
                'typ_odbiorcy' => 'user',
                'plik_id' => $plikiIdArr,
            ]);
        } else {
            Message::create([
                'wiadomosc' => $request->message,
                'odbiorca_id' => (int) $receiver_id,
                'nadawca_id' => $sender_id,
                'typ_odbiorcy' => 'user',
            ]);
        }

        $friendInfo = DB::select("select * from users where id=" . $sender_id);
        $data = array(
            'nadawca_id' => $sender_id,
            'odbiorca_id' => $receiver_id,
            'wiadomosc' => $request->message,
            'avatar' => $friendInfo[0]->avatar,
            'data' => date("Y-m-d H:i:s"),
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
        $roz = explode('/', $_FILES["file"]['type']);
        if ('image' == $roz[0]) {
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if (false !== $check) {
                $maxDim = 1280;
                $file_name = $_FILES['file']['tmp_name'];
                $target_filename = $file_name;
                list($width, $height, $type, $attr) = getimagesize($file_name);
                if ($width > $maxDim || $height > $maxDim) {
                    $ratio = $width / $height;
                    if ($ratio > 1) {
                        $new_width = $maxDim;
                        $new_height = $maxDim / $ratio;
                    } else {
                        $new_width = $maxDim * $ratio;
                        $new_height = $maxDim;
                    }
                    $src = imagecreatefromstring(file_get_contents($file_name));
                    $dst = imagecreatetruecolor($new_width, $new_height);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagedestroy($src);
                    imagepng($dst, $target_filename); // adjust format as needed
                    imagedestroy($dst);
                }
                $nazwa = uniqid();
                move_uploaded_file($target_filename,
                    __DIR__ . '/../../../public/uploads/pliki/' . $nazwa . '.' . $roz[1]);
                echo json_encode(['plik' => '<img style="width:50px;height:50px;" src="/uploads/pliki/' . $nazwa . '.' . $roz[1] . '" data-nazwa="' . $nazwa . '.' . $roz[count($roz) - 1] . '">']);
                Files::create([
                    'nazwa' => $nazwa . '.' . $roz[1],
                    'rozszerzenie' => $roz[1],
                    'przeznaczenie' => 'wiadomosc',
                    'uzytkownik_id' => Auth::id(),
                ]);
            }
        } else {
            $nazwa = uniqid();
            move_uploaded_file($_FILES['file']['tmp_name'],
                __DIR__ . '/../../../public/uploads/pliki/' . $nazwa . '.' . $roz[1]);
            $roz = explode('.', $_FILES['file']['name']);
            echo json_encode(['plik' => '<a href="/uploads/pliki/' . $nazwa . '.' . $roz[count($roz) - 1] . '" data-nazwa="' . $nazwa . '.' . $roz[count($roz) - 1] . '">' . $nazwa . '.' . $roz[count($roz) - 1] . '</a>']);
            Files::create([
                'nazwa' => $nazwa . '.' . $roz[1],
                'rozszerzenie' => $roz[1],
                'przeznaczenie' => 'wiadomosc',
                'uzytkownik_id' => Auth::id(),
            ]);
        }
    }
}
