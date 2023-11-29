<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use Response;

class ChatController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function index() {
      if (Auth::user()->role_id == "9") {
       return view('chat.index');
      } else if (Auth::user()->role_id == "2") {
       return view('chatdinas.index');
      }
    }

    public function apicountchat(Request $req) {
      $user = DB::table("user")->where("id", $req->id)->first();

      if ($user->role_id == 2) {
        $chat = DB::table('roomchat')
        ->where('account', 'like', '%admindinas%')
        ->get();

        $count = 0;

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] == "admindinas") {
              $count += $value->counter_satu;
          } else {
              $count += $value->counter_kedua;
          }
        }

        return Response()->json($count);
      } else if ($user->role_id == 9) {
        $chat = DB::table('roomchat')
        ->where('account', 'like', '%'. $user->id .'%')
        ->get();

        $count = 0;

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] == $user->id ) {
              $count += $value->counter_satu;
          } else {
              $count += $value->counter_kedua;
          }
        }

        return Response()->json($count);
      } else {
        return Response()->json("role user tidak sesuai");
      }
    }

    public function listroom(Request $req) {
        $chat = DB::table('roomchat')
                 ->where('account', 'like', '%admindinas%')
                 ->orderby("created_at", "DESC")
                 ->get();

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] != Auth::user()->id) {
            $value->account = DB::table("user")
                                ->where("id", $account[0])
                                ->first();
          } else if ($account[1] != Auth::user()->id) {
            $value->account = DB::table("user")
                                ->where("id", $account[1])
                                ->first();
          }

          $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }

         return Response()->json($chat);
    }

    public function apilistroom(Request $req) {
      $chat = DB::table('roomchat')
            ->where('account', 'like', '%admindinas%')
            ->orderby("created_at", "DESC")
            ->get();

      foreach ($chat as $key => $value) {
      $account = explode("-",$value->account);

      if ($account[0] != $req->id) {
      $value->account = DB::table("user")
                          ->where("id", $account[0])
                          ->first();
      } else if ($account[1] != $req->id) {
      $value->account = DB::table("user")
                          ->where("id", $account[1])
                          ->first();
      }

      $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
      }

      return Response()->json($chat);
    }

    public function listchat(Request $req) {

        if (Auth::user()->role_id == 9) {
          $chat = DB::table('listchat')
                 ->where("account", Auth::user()->id . "-admindinas")
                 ->get();

          $allchat = DB::table('listchat')
          ->where("roomchat_id", $chat[0]->roomchat_id)
          ->get();

          DB::table('listchat')
          ->where("roomchat_id", $chat[0]->roomchat_id)
          ->update([
            'read' => 1,
          ]);

          $room = DB::table('roomchat')
              ->where("id", $chat[0]->roomchat_id)
              ->first();
          // foreach ($chat as $key => $value) {
          $account = explode("-",$room->account);

          if ($account[0] == Auth::user()->id) {
            DB::table('roomchat')
                 ->where("id", $chat[0]->roomchat_id)
                 ->update([
                   'counter_satu' => 0,
                 ]);

          } else {
            DB::table('roomchat')
                 ->where("id", $chat[0]->roomchat_id)
                 ->update([
                   'counter_kedua' => 0,
                 ]);
          }
        } else {
          $allchat = DB::table('listchat')
          ->where("roomchat_id", $req->id)
          ->get();

          DB::table('listchat')
          ->where("roomchat_id", $req->id)
          ->update([
            'read' => 1,
          ]);

          $room = DB::table('roomchat')
              ->where("id", $req->id)
              ->first();
          // foreach ($chat as $key => $value) {
          $account = explode("-",$room->account);

          if ($account[0] == Auth::user()->id) {
            DB::table('roomchat')
                  ->where("id", $req->id)
                  ->update([
                    'counter_satu' => 0,
                  ]);

          } else {
            DB::table('roomchat')
                  ->where("id", $req->id)
                  ->update([
                    'counter_kedua' => 0,
                  ]);
          }
        }
         
         foreach ($allchat as $key => $value) {
           $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
         }

         return Response()->json($allchat);
    }

    public function apilistchat(Request $req) {
      if ($req->role_id == 9) {
        $chat = DB::table('listchat')
               ->where("account", $req->id . "-admindinas")
               ->get();

        $allchat = DB::table('listchat')
        ->where("roomchat_id", $chat[0]->roomchat_id)
        ->get();

        DB::table('listchat')
        ->where("roomchat_id", $chat[0]->roomchat_id)
        ->update([
          'read' => 1,
        ]);

        $room = DB::table('roomchat')
            ->where("id", $chat[0]->roomchat_id)
            ->first();
        // foreach ($chat as $key => $value) {
        $account = explode("-",$room->account);

        if ($account[0] == $req->id) {
          DB::table('roomchat')
               ->where("id", $chat[0]->roomchat_id)
               ->update([
                 'counter_satu' => 0,
               ]);

        } else {
          DB::table('roomchat')
               ->where("id", $chat[0]->roomchat_id)
               ->update([
                 'counter_kedua' => 0,
               ]);
        }
      } else {
        $allchat = DB::table('listchat')
        ->where("roomchat_id", $req->id)
        ->get();

        DB::table('listchat')
        ->where("roomchat_id", $req->id)
        ->update([
          'read' => 1,
        ]);

        $room = DB::table('roomchat')
            ->where("id", $req->id)
            ->first();
        // foreach ($chat as $key => $value) {
        $account = explode("-",$room->account);

        if ($account[0] == $req->id) {
          DB::table('roomchat')
                ->where("id", $req->id)
                ->update([
                  'counter_satu' => 0,
                ]);

        } else {
          DB::table('roomchat')
                ->where("id", $req->id)
                ->update([
                  'counter_kedua' => 0,
                ]);
        }
      }
       
       foreach ($allchat as $key => $value) {
         $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
       }

       return Response()->json($allchat);
    }

    public function sendchat(Request $req) {
      DB::beginTransaction();
      try {
          if (Auth::user()->role_id == 9) {
            $getadmindinas = DB::table('user')
            ->where("role_id", 2)
            ->get();

              $cek = DB::table("roomchat")
              ->Orwhere("account", Auth::user()->id . "-admindinas")
              ->Orwhere('account', "admindinas-" . Auth::user()->id)
              ->first();

              if ($cek != null) {
                DB::table('roomchat')
                ->where("id", $cek->id)
                ->update([
                  'last_message' => $req->message,
                  'counter_kedua' => $cek->counter_kedua + 1,
                  'created_at' => Carbon::now('Asia/Jakarta'),
                ]);
   
               DB::table("listchat")
                  ->insert([
                    'roomchat_id' => $cek->id,
                    'account' => Auth::user()->id . "-admindinas",
                    'message' => $req->message,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $botchat = DB::table("chatbot")->where("id", 1)->first();
                  if ($botchat->is_active == "Y") {
                    $now = Carbon::now('Asia/Jakarta');
                    $time = $now->format('H:i'); 

                    if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
                      DB::table("listchat")
                        ->insert([
                          'roomchat_id' => $cek->id,
                          'account' => "admindinas-" . Auth::user()->id,
                          'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
                          'created_at' => Carbon::now('Asia/Jakarta'),
                        ]);
                    }
                  }
              } else {
                $id = DB::table('roomchat')
                      ->insertGetId([
                        'account' => Auth::user()->id . "-admindinas",
                        'last_message' => $req->message,
                        'counter_kedua' => 1,
                        'created_at' => Carbon::now('Asia/Jakarta'),
                      ]);

                DB::table("listchat")
                  ->insert([
                    'roomchat_id' => $id,
                    'account' => Auth::user()->id . "-admindinas",
                    'message' => $req->message,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $botchat = DB::table("chatbot")->where("id", 1)->first();
                  if ($botchat->is_active == "Y") {
                    $now = Carbon::now('Asia/Jakarta');
                    $time = $now->format('H:i');
  
                    if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
                      DB::table("listchat")
                        ->insert([
                          'roomchat_id' => $id,
                          'account' => "admindinas-" . Auth::user()->id,
                          'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
                          'created_at' => Carbon::now('Asia/Jakarta'),
                        ]);
                    }
                  }
              }
          } else {
            $room = DB::table("roomchat")->where("id", $req->id)->first();

            $account = explode("-",$room->account);
            
            DB::table("listchat")
            ->insert([
              'roomchat_id' => $req->id,
              'account' => "admindinas-" . $account[0],
              'message' => $req->message,
              'created_at' => Carbon::now('Asia/Jakarta'),
            ]);
          }

           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }

    public function apisendchat(Request $req) {
      DB::beginTransaction();
      try {
          if ($req->role_id == 9) {
            $getadmindinas = DB::table('user')
            ->where("role_id", 2)
            ->get();

              $cek = DB::table("roomchat")
              ->Orwhere("account", $req->id . "-admindinas")
              ->Orwhere('account', "admindinas-" . $req->id)
              ->first();

              if ($cek != null) {
                DB::table('roomchat')
                ->where("id", $cek->id)
                ->update([
                  'last_message' => $req->message,
                  'counter_kedua' => $cek->counter_kedua + 1,
                  'created_at' => Carbon::now('Asia/Jakarta'),
                ]);
   
               DB::table("listchat")
                  ->insert([
                    'roomchat_id' => $cek->id,
                    'account' => $req->id . "-admindinas",
                    'message' => $req->message,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $botchat = DB::table("chatbot")->where("id", 1)->first();
                  if ($botchat->is_active == "Y") {
                    $now = Carbon::now('Asia/Jakarta');
                    $time = $now->format('H:i'); 

                    if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
                      DB::table("listchat")
                        ->insert([
                          'roomchat_id' => $cek->id,
                          'account' => "admindinas-" . $req->id,
                          'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
                          'created_at' => Carbon::now('Asia/Jakarta'),
                        ]);
                    }
                  }
              } else {
                $id = DB::table('roomchat')
                      ->insertGetId([
                        'account' => $req->id . "-admindinas",
                        'last_message' => $req->message,
                        'counter_kedua' => 1,
                        'created_at' => Carbon::now('Asia/Jakarta'),
                      ]);

                DB::table("listchat")
                  ->insert([
                    'roomchat_id' => $id,
                    'account' => $req->id . "-admindinas",
                    'message' => $req->message,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $botchat = DB::table("chatbot")->where("id", 1)->first();
                  if ($botchat->is_active == "Y") {
                    $now = Carbon::now('Asia/Jakarta');
                    $time = $now->format('H:i');
  
                    if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
                      DB::table("listchat")
                        ->insert([
                          'roomchat_id' => $id,
                          'account' => "admindinas-" . $req->id,
                          'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
                          'created_at' => Carbon::now('Asia/Jakarta'),
                        ]);
                    }
                  }
              }
          } else {
            $room = DB::table("roomchat")->where("id", $req->id)->first();

            $account = explode("-",$room->account);
            
            DB::table("listchat")
            ->insert([
              'roomchat_id' => $req->id,
              'account' => "admindinas-" . $account[0],
              'message' => $req->message,
              'created_at' => Carbon::now('Asia/Jakarta'),
            ]);
          }

           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }
}
