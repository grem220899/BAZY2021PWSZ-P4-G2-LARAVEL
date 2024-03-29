<?php

namespace App\Http\Controllers;

use App\Models\BanList;
use App\Models\Files;
use App\Models\FriendList;
use App\Models\Message;
use App\Models\Wulgaryzmy;
use App\Models\Zamienniki;
use DB;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function logowanie()
    {
        $data = array();
        header('Content-Type: application/json');
        // $password = urldecode($_GET["password"]);
        $password = $_GET["password"];
        $data["pass_1"] = $_GET["password"];
        $data["pass_2"] = urldecode($_GET["password"]);
        $u = DB::select("select * from users where email='" . $_GET['email'] . "'");
        if (count($u) > 0) {
            if (password_verify($password, $u[0]->password)) {
                $data["status"] = "success";
                $data["message"] = "";
                $data["data"] = $u[0];
                $data["data"]->avatar = "http://projektkt.pl/uploads/avatars/" . $data["data"]->avatar;
            } else {
                $data["status"] = "failed";
                $data["message"] = "nie udało sie zalogować";
                $data["data"] = null;
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "nie udało sie zalogować";
            $data["data"] = null;
        }
        echo json_encode($data);
    }
    public function changeAvatar()
    {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if (false !== $check) {
            $roz = explode('/', $_FILES['file']['type']);
            $nazwa = uniqid();
            Files::create([
                'nazwa' => $nazwa,
                'rozszerzenie' => $roz[1],
                'przeznaczenie' => 'avatar',
                'uzytkownik_id' => Auth::id(),
            ]);
            move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '/../../../public/uploads/avatars/' . $nazwa . '.' . $roz[1]);
            DB::update('UPDATE users SET avatar="' . $nazwa . '.' . $roz[1] . '" WHERE id=' . Auth::id());

            echo json_encode($nazwa . '.' . $roz[1]);

        } else {
            echo json_encode(0);
        }
    }

    public function friend_list()
    {
        header('Content-Type: application/json');
        $data = array();
        if (isset($_GET['id'])) {
            $friend_list = DB::select("select * from friend_list where (user_id=" . $_GET['id'] . " OR friend_id=" . $_GET['id'] . ") AND accepted=1");
            $friend_list_arr = [];
            foreach ($friend_list as $v) {
                if ($_GET['id'] == $v->friend_id) {
                    $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->user_id);
                } else {
                    $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->friend_id);
                }
                $w[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $w[0]->avatar;

                $friend_list_arr[] = $w[0];
            }

            $data["status"] = "success";
            $data["message"] = "";
            $data["data"] = $friend_list_arr;

        } else {

            $data["status"] = "failed";
            $data["message"] = "brak id";
            $data["data"] = [];

        }
        echo json_encode($data);

    }

    public function wysylanie_zaproszenia()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['email'])) {
            if (isset($_GET['id'])) {
                $u = DB::select("select id,name,surname,nick,email,avatar,status from users where email='" . $_GET['email'] . "'");
                if (!empty($u)) {
                    $spr = DB::select("select * from friend_list where (friend_id=" . $u[0]->id . " AND `user_id`=" . $_GET['id'] . ") OR (friend_id=" . $_GET['id'] . " AND `user_id`=" . $u[0]->id . ")");
                    if (empty($spr)) {
                        $spr_ban = DB::select("select * from ban_list where (user_id =" . $_GET['id'] . " AND `user_ban_id`=" . $u[0]->id . ") OR (`user_id` =" . $u[0]->id . " AND `user_ban_id`=" . $_GET['id'] . ")");
                        if (empty($spr_ban)) {
                            $data['data'] = $u[0];
                            FriendList::insert([
                                'user_id' => $_GET['id'],
                                'friend_id' => $u[0]->id,
                                'accepted' => 0,
                                'date_add' => date("Y-m-d H:i:s"),
                            ]);
                            $data["status"] = "success";
                        } else {
                            $data["status"] = "failed";
                            $data["message"] = "Zostales zablokowany przez tego uzytkownika";
                        }
                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "Zaproszenie zostało wcześniej wysłane";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie ma takiego adresu email w bazie.";
                }

            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano id";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano emaila";
        }
        echo json_encode($data);
    }

    public function akceptowanie_zaproszenia()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            if (isset($_GET['friend_id'])) {
                DB::update("update friend_list set accepted=1 WHERE (user_id=" . $_GET['user_id'] . " AND friend_id=" . $_GET['friend_id'] . ") OR (user_id=" . $_GET['friend_id'] . " AND friend_id=" . $_GET['user_id'] . ")");
                $data["status"] = "success";
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano friend_id ";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function usuwanie_znajomych()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            if (isset($_GET['friend_id'])) {
                DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_GET['user_id'] . " AND friend_id=" . $_GET['friend_id'] . ") OR (user_id=" . $_GET['friend_id'] . " AND friend_id=" . $_GET['user_id'] . ")");
                $data["status"] = "success";
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano friend_id ";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function banowanie_znajomych()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_ban_id'])) {
            if (isset($_GET['user_id'])) {
                $u = DB::select("select id,name,surname,nick,email,avatar,status from users where id='" . $_GET['user_id'] . "'");
                if (!empty($u)) {
                    $spr = DB::select("select * from ban_list where (user_ban_id=" . $_GET['user_ban_id'] . " AND
                    `user_id`=" . $_GET['user_id'] . ") OR (user_ban_id=" . $_GET['user_id'] . " AND `user_id`=" . $_GET['user_ban_id'] . ")");
                    if (empty($spr)) {
                        $data['data'] = $u[0];
                        DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_GET['user_id'] . " AND friend_id=" . $_GET['user_ban_id'] .
                            ") OR (user_id=" . $_GET['user_ban_id'] . " AND friend_id=" . $_GET['user_id'] . ")");
                        BanList::insert([
                            'date_ban' => date("Y-m-d H:i:s"),
                            'date_uban' => null,
                            'user_id' => (int) $_GET['user_id'],
                            'user_ban_id' => (int) $_GET['user_ban_id'],
                        ]);
                        $data["status"] = "success";
                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "User został wcześniej zbanowany";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie ma takiego user_id w bazie";
                }

            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano user_id";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_ban_id";
        }
        echo json_encode($data);
    }

    public function wyslane_zaproszenia()
    {
        $data = array();
        header('Content-Type: application/json');
        if (isset($_GET['user_id'])) {
            $u = DB::select("select * from friend_list where user_id=" . $_GET['user_id'] . " AND accepted=0");
            if (!empty($u)) {
                $waiting_arr = [];
                foreach ($u as $v) {
                    $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->friend_id);
                    $w[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $w[0]->avatar;
                    $waiting_arr[] = $w[0];
                }

                $data["status"] = "success";
                $data["data"] = $waiting_arr;
            } else {
                $data["status"] = "success";
                $data["message"] = "Brak wyslanych zaproszen";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano id";
            $data["data"] = [];
        }

        echo json_encode($data);
    }

    public function odebrane_zaproszenia()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            $u = DB::select("select * from friend_list where friend_id=" . $_GET['user_id'] . " AND accepted=0");
            if (!empty($u)) {
                $waiting_arr = [];
                foreach ($u as $v) {
                    $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->user_id);
                    $w[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $w[0]->avatar;
                    $waiting_arr[] = $w[0];
                }

                $data["status"] = "success";
                $data["data"] = $waiting_arr;
            } else {
                $data["status"] = "success";
                $data["message"] = "Brak odebranych zaproszen ";
            }

        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function lista_zbanowanych()
    {

        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            $u = DB::select("select * from ban_list where user_id=" . $_GET['user_id'] . "");
            if (!empty($u)) {
                $waiting_arr = [];
                foreach ($u as $v) {
                    $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->user_ban_id);
                    $w[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $w[0]->avatar;
                    $waiting_arr[] = $w[0];
                }

                $data["status"] = "success";
                $data["data"] = $waiting_arr;
            } else {
                $data["status"] = "failed";
                $data["message"] = "Brak zbanowanego uzytkownika ";
            }

        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function odbanowanie_znajomego()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_ban_id'])) {
            if (isset($_GET['user_id'])) {
                DB::delete("DELETE FROM ban_list WHERE ( `user_id`=" . $_GET['user_id'] . " AND `user_ban_id`=" . $_GET['user_ban_id'] .
                    ") OR (`user_id`=" . $_GET['user_ban_id'] . " AND `user_ban_id`=" . $_GET['user_id'] . ")");
                $data["status"] = "success";
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano user_id";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_ban_id";
        }
        echo json_encode($data);
    }

    public function odbieranie_wiadomosci()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['id'])) {
            if (isset($_GET['odbiorca_id'])) {
                if (isset($_GET['strona'])) {
                    if (isset($_GET['typ_odbiorcy'])) {
                        $userId = (int) $_GET['odbiorca_id'];
                        $friendInfo = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $userId);
                        $myInfo = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $_GET['id']);
                        $this->data['userId'] = $userId;
                        $this->data['friendInfo'] = $friendInfo;
                        $this->data['myInfo'] = $myInfo;
                        $this->data['typOdbiorcy'] = $_GET['typ_odbiorcy'];
                        if ($_GET['typ_odbiorcy'] == "grupa") {
                            $this->data['messages'] = Message::whereIn('odbiorca_id', [(int) $_GET['odbiorca_id']])->orderBy('created_at', 'desc')->where("typ_odbiorcy", $_GET['typ_odbiorcy'])->limit(20)->skip(20 * (int) $_GET['strona'])->get();
                        } else {
                            $this->data['messages'] = Message::whereIn('nadawca_id', [(int) $userId, (int) $_GET['id']])->whereIn('odbiorca_id', [(int) $userId, (int) $_GET['id']])->orderBy('created_at', 'desc')->where("typ_odbiorcy", $_GET['typ_odbiorcy'])->limit(20)->skip(20 * (int) $_GET['strona'])->get();
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
                            if ($_GET['typ_odbiorcy'] == "grupa") {
                                $uzytkownik = DB::select("SELECT id,name,surname,nick,email,avatar,status FROM users WHERE id=" . $mess['nadawca_id']);
                                $uzytkownik[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $uzytkownik[0]->avatar;
                                $mess['dane_uzytkownika'] = $uzytkownik[0];
                            }
                        }
                        $this->data['pliki'] = $files = Files::whereIn('_id', $filesId)->get();
                        $files2 = [];
                        foreach ($files as $f) {
                            $files2[$f['_id']] = $f;
                        }

                        $this->data['pliki'] = $files2;
                        $data["status"] = "success";
                        $data["data"] = $this->data;

                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "Nie podano typu odbiorcy";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie podano strony";
                }

            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano odbiorcy";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano id";
        }

        echo json_encode($data);
    }

    public function wysylanie_wiadomosci()
    {

        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['nadawca_id'])) {
            if (isset($_GET['odbiorca_id'])) {
                if (isset($_GET['message'])) {
                    if (isset($_GET['typ_odbiorcy'])) {
                        $sender_id = $_GET['nadawca_id'];
                        $receiver_id = $_GET['odbiorca_id'];
                        Message::create([
                            'wiadomosc' => $_GET['message'],
                            'odbiorca_id' => (int) $receiver_id,
                            'nadawca_id' => (int) $sender_id,
                            'typ_odbiorcy' => $_GET['typ_odbiorcy'],

                        ]);
                        $friendInfo = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $sender_id);
                        $data2 = array(
                            'nadawca_id' => $sender_id,
                            'odbiorca_id' => $receiver_id,
                            'wiadomosc' => $_GET['message'],
                            'avatar' => "http://projektkt.pl/uploads/avatars/" . $friendInfo[0]->avatar,
                            'data' => date("Y-m-d H:i:s"),
                            'typ_odbiorcy' => $_GET['typ_odbiorcy'],
                        );
                        $data["status"] = "success";
                        $data["data"] = $data2;
                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "Nie podano typu odbiorcy";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie podano wiadomosci";
                }
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano odbiorcy";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano nadawcy";
        }

        echo json_encode($data);
    }

    public function wulgaryzmy()
    {
        header('Content-Type: application/json');
        $wul = Wulgaryzmy::whereIn('aktywny', [1])->get();
        $wul_arr = [];
        foreach ($wul as $w) {
            $wul_arr[] = $w['nazwa'];
        }
        echo json_encode($wul_arr);
    }
    public function zamienniki()
    {
        header('Content-Type: application/json');
        $wul = Zamienniki::whereIn('aktywny', [1])->get();
        $wul_arr = [];
        foreach ($wul as $w) {
            $wul_arr[] = $w['nazwa'];
        }
        echo json_encode($wul_arr);
    }

    public function utworz_grupe()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['nazwa_grupy'])) {
            if (isset($_GET['id_wlasciciela'])) {
                if (isset($_GET['czlonkowie'])) {
                    DB::insert('INSERT INTO `group_name`(`id`, `name`, `owner_id`) VALUES (null,"' . $_GET['nazwa_grupy'] . '",' . $_GET['id_wlasciciela'] . ')');
                    $id_grupy = DB::select('SELECT id from group_name WHERE name="' . $_GET['nazwa_grupy'] . '" ORDER BY name DESC');
                    $_GET['czlonkowie'] = explode(",", $_GET['czlonkowie']);
                    foreach ($_GET['czlonkowie'] as $czlonek) {
                        DB::insert('INSERT INTO `group`(`id`, `user_id`, `name_group_id`) VALUES (null,' . $czlonek . ',' . $id_grupy[0]->id . ')');
                    }
                    $data2 = array(
                        'nazwa_grupy' => $_GET['nazwa_grupy'],
                        'id_wlasciciela' => $_GET['id_wlasciciela'],
                        'id_czlonkow' => $_GET['czlonkowie'],
                    );
                    $data["status"] = "success";
                    $data["data"] = $data2;
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie podano nazwy grupy";
                }
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano wlasciciela";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano czlonkow grupy";
        }

        echo json_encode($data);
    }
    public function lista_grup()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['owner_id'])) {
            $grupy = DB::select('SELECT * FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE g.name_group_id IN (SELECT name_group_id FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE user_id=' . $_GET['owner_id'] . ' OR gn.owner_id=' . $_GET['owner_id'] . ')');
            $grupy_arr = ['czlonkowie' => [], 'nazwy' => []];
            $owner = 0;
            $nazwa = "";
            foreach ($grupy as $v) {
                $w = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->user_id);
                if ($v->name != $nazwa) {
                    $grupy_arr['nazwy'][] = ['nazwa' => $v->name, 'id' => $v->name_group_id];
                    $ww = DB::select("select id,name,surname,nick,email,avatar,status from users where id=" . $v->owner_id);
                    $grupy_arr['czlonkowie'][$v->name][] = $ww[0];
                }
                $nazwa = $v->name;
                $owner = $v->owner_id;
                $grupy_arr['czlonkowie'][$nazwa][] = $w[0];
            }

            $data["status"] = "success";
            $data["data"] = $grupy_arr;
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano wlasciciela";
        }
        echo json_encode($data);
    }
    public function usun_grupe()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        //if (isset($_GET['owner_id'])) {
            if (isset($_GET['id_grupy'])) {
                if (isset($_GET['id_osoby'])) {
                    $owner = DB::select("SELECT owner_id FROM group_name WHERE (owner_id=" . $_GET['id_osoby'] . " AND id=" . $_GET['id_grupy'] . ")");
                    $ifExist = DB::select("SELECT id FROM group_name WHERE (id=" . $_GET['id_grupy'] . " )");
                    if ($ifExist != null) {
                        if ($owner != null) {
                            DB::delete("DELETE FROM group_name WHERE (owner_id=" . $_GET['id_osoby'] . " AND id=" . $_GET['id_grupy'] . ") ");
                            $data["status"] = "success";
                        } else {
                            $data["status"] = "failed";
                            $data["message"] = "Ten uzytkownik nie jest wlascicielem grupy ";
                        }
                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "Grupa o podanym id nie istnieje";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie podano id osoby ";

                }
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano id grupy ";
            }
        // } else {
        //     $data["status"] = "failed";
        //     $data["message"] = "Nie podano id wlasciciela ";
        // }
        echo json_encode($data);
    }
}
