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
       return view('chat.index');
    }

    public function newroom(Request $req) {
      DB::beginTransaction();
      try {

            $cek = DB::table("roomchat")
                      ->where("account", Auth::user()->id . "-" . $req->id)
                      ->first();

            if ($cek != null) {
              DB::table('roomchat')
              ->where("id", $cek->id)
              ->update([
                "created_at" => Carbon::now('Asia/Jakarta'),
              ]);
            } else {
              DB::table('roomchat')
                ->insert([
                  'account' => Auth::user()->id . "-" . $req->id,
                  'last_message' => "",
                  'counter_kedua' => 0,
                  'created_at' => Carbon::now('Asia/Jakarta'),
              ]);
            }
  
           DB::commit();
           return Response()->json("sukses");
      } catch (\Exception $e) {
           DB::rollback();
           return Response()->json("gagal");
      }
    }

    public function apinewroom(Request $req) {
      DB::beginTransaction();
      try {

            $cek = DB::table("roomchat")
                      ->where("account", $req->auth_id . "-" . $req->id)
                      ->first();

            if ($cek != null) {
              DB::table('roomchat')
              ->where("id", $cek->id)
              ->update([
                "created_at" => Carbon::now('Asia/Jakarta'),
              ]);
            } else {
              DB::table('roomchat')
                ->insert([
                  'account' => Auth::user()->id . "-" . $req->id,
                  'last_message' => "",
                  'counter_kedua' => 0,
                  'created_at' => Carbon::now('Asia/Jakarta'),
              ]);
            }
  
           DB::commit();
           return Response()->json("sukses");
      } catch (\Exception $e) {
           DB::rollback();
           return Response()->json("gagal");
      }
    }

    public function apicountchat(Request $req) {
        $user = DB::table("user")->where("id", $req->id)->first();

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
    }

    public function listroom(Request $req) {
        $resultRoom = array();
        $getOperator = DB::table("user")->where("role_id", "5")->first();

        if (Auth::user()->role_id == "9" || Auth::user()->role_id == "7" ) {
          $cekOperatorRoom = $chat = DB::table('roomchat')
                                      ->where('account', 'like', '%' . Auth::user()->id . "-" . $getOperator->id . '%')
                                      ->orderby("created_at", "DESC")
                                      ->first();

          if($cekOperatorRoom != null) {
            $account = explode("-",$cekOperatorRoom->account);

            if ($account[0] != Auth::user()->id) {
              $cekOperatorRoom->account = DB::table("user")
                                  ->where("id", $account[0])
                                  ->first();
            } else if ($account[1] != Auth::user()->id) {
              $cekOperatorRoom->account = DB::table("user")
                                  ->where("id", $account[1])
                                  ->first();
            }
  
            $cekOperatorRoom->created_at = Carbon::parse($cekOperatorRoom->created_at)->diffForHumans();

            $resultRoom[0] = $cekOperatorRoom;

            // dd($resultRoom);
          } else {
            DB::table('roomchat')
              ->insert([
                'account' => Auth::user()->id . "-" . $getOperator->id,
                'last_message' => "",
                'counter_kedua' => 0,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

            $cekOperatorRoom = $chat = DB::table('roomchat')
                                        ->where('account', 'like', '%' . Auth::user()->id . "-" . $getOperator->id . '%')
                                        ->orderby("created_at", "DESC")
                                        ->first();
            
            if($cekOperatorRoom != null) {
              $account = explode("-",$cekOperatorRoom->account);

              if ($account[0] != Auth::user()->id) {
                $cekOperatorRoom->account = DB::table("user")
                                    ->where("id", $account[0])
                                    ->first();
              } else if ($account[1] != Auth::user()->id) {
                $cekOperatorRoom->account = DB::table("user")
                                    ->where("id", $account[1])
                                    ->first();
              }
    
              $cekOperatorRoom->created_at = Carbon::parse($cekOperatorRoom->created_at)->diffForHumans();

              $resultRoom[0] = $cekOperatorRoom;
            }
          }
        }

        if (Auth::user()->role_id == "9" || Auth::user()->role_id == "7" ) {
          $chat = DB::table('roomchat')
                  ->where('account', 'like', '%' . Auth::user()->id . '%')
                  ->where('account', 'not like', '%' . $getOperator->id . '%')
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
  
            $resultRoom[$key + 1] = $value;
          }
        } else {
          $chat = DB::table('roomchat')
          ->where('account', 'like', '%' . Auth::user()->id . '%')
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
  
            $resultRoom[$key] = $value;
          }
        }

        $peringatan = false;
        $botchat = DB::table("chatbot")->where("id", 1)->first();
        if ($botchat->is_active == "Y") {
          $now = Carbon::now('Asia/Jakarta');
          $time = $now->format('H:i');

          if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
            $peringatan = true;
          }
        }

        return Response()->json([
          "data" => $resultRoom,
          "peringatan" => $peringatan
        ]);
    }

    public function apilistroom(Request $req) {
      $resultRoom = array();
      $getOperator = DB::table("user")->where("role_id", "5")->first();

      if ($req->role_id == "9" || $req->role_id == "7" ) {
        $cekOperatorRoom = $chat = DB::table('roomchat')
                                    ->where('account', 'like', '%' . $req->id . "-" . $getOperator->id . '%')
                                    ->orderby("created_at", "DESC")
                                    ->first();
        
        if($cekOperatorRoom != null) {
          $account = explode("-",$cekOperatorRoom->account);

          if ($account[0] != $req->id) {
            $cekOperatorRoom->account = DB::table("user")
                                ->where("id", $account[0])
                                ->first();
          } else if ($account[1] != $req->id) {
            $cekOperatorRoom->account = DB::table("user")
                                ->where("id", $account[1])
                                ->first();
          }

          $cekOperatorRoom->created_at = Carbon::parse($cekOperatorRoom->created_at)->diffForHumans();

          $resultRoom[0] = $cekOperatorRoom;
        } else {
          DB::table('roomchat')
            ->insert([
              'account' => $req->id . "-" . $getOperator->id,
              'last_message' => "",
              'counter_kedua' => 0,
              'created_at' => Carbon::now('Asia/Jakarta'),
          ]);

          $cekOperatorRoom = $chat = DB::table('roomchat')
                                      ->where('account', 'like', '%' . $req->id . "-" . $getOperator->id . '%')
                                      ->orderby("created_at", "DESC")
                                      ->first();
          
          if($cekOperatorRoom != null) {
            $account = explode("-",$cekOperatorRoom->account);

            if ($account[0] != $req->id) {
              $cekOperatorRoom->account = DB::table("user")
                                  ->where("id", $account[0])
                                  ->first();
            } else if ($account[1] != $req->id) {
              $cekOperatorRoom->account = DB::table("user")
                                  ->where("id", $account[1])
                                  ->first();
            }
  
            $cekOperatorRoom->created_at = Carbon::parse($cekOperatorRoom->created_at)->diffForHumans();

            $resultRoom[0] = $cekOperatorRoom;
          }
        }
      }
      
      if ($req->role_id == "9" || $req->role_id == "7" ) {
        $chat = DB::table('roomchat')
                ->where('account', 'like', '%' . $req->id . '%')
                ->where('account', 'not like', '%' . $getOperator->id . '%')
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
  
          $resultRoom[$key + 1] = $value;
        }
      } else {
        $chat = DB::table('roomchat')
        ->where('account', 'like', '%' . $req->id. '%')
        ->orderby("created_at", "DESC")
        ->get();

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);
  
          if ($account[0] != Auth::user()->id) {
            $value->account = DB::table("user")
                                ->where("id", $account[0])
                                ->first();
          } else if ($account[1] != $req->id) {
            $value->account = DB::table("user")
                                ->where("id", $account[1])
                                ->first();
          }
  
          $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
  
          $resultRoom[$key] = $value;
        }
      }
      
      $peringatan = false;
      $botchat = DB::table("chatbot")->where("id", 1)->first();
      if ($botchat->is_active == "Y") {
        $now = Carbon::now('Asia/Jakarta');
        $time = $now->format('H:i');

        if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
          $peringatan = true;
        }
      }

      return Response()->json([
        "data" => $resultRoom,
        "peringatan" => $peringatan
      ]);
    }

    public function listchat(Request $req) {
      $chat = DB::table('listchat')
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

       if ($account[0] == Auth::user()->id_account) {

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

      foreach ($chat as $key => $value) {
        $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
      }

      return Response()->json($chat);
 }

 public function apilistchat(Request $req) {
      $chat = DB::table('listchat')
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

       if ($account[0] == $req->id_account) {

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

      foreach ($chat as $key => $value) {
        $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
      }

      return Response()->json($chat);
   }

   public function sendchat(Request $req) {
    DB::beginTransaction();
    try {

        // $chat = DB::table('listchat')
        //         ->where("id_roomchat", $req->id)
        //         ->get();

         DB::table("listchat")
            ->insert([
              'roomchat_id' => $req->id,
              'account' => Auth::user()->id . "-" . $req->penerima,
              'message' => $req->message,
              'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

          $this->aksesBot($req->id, Auth::user()->id, $req->penerima);

          $count = 0;
          $room = DB::table('roomchat')
               ->where("id", $req->id)
               ->first();
           // foreach ($chat as $key => $value) {
             $account = explode("-",$room->account);

             if ($account[0] != Auth::user()->id) {

               $count = $room->counter_satu;

               DB::table('roomchat')
                    ->where("id", $req->id)
                    ->update([
                      'last_message' => $req->message,
                      'counter_satu' => $count + 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);
             } else {

               $count = $room->counter_kedua;

               DB::table('roomchat')
                    ->where("id", $req->id)
                    ->update([
                      'last_message' => $req->message,
                      'counter_kedua' => $count + 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);
             }
           // }

         DB::commit();
    } catch (\Exception $e) {
         DB::rollback();
    }
  }

  public function apisendchat(Request $req) {
    DB::beginTransaction();
    try {

        // $chat = DB::table('listchat')
        //         ->where("id_roomchat", $req->id)
        //         ->get();

         DB::table("listchat")
            ->insert([
              'roomchat_id' => $req->id,
              'account' => $req->id . "-" . $req->penerima,
              'message' => $req->message,
              'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

          $this->aksesBot($req->id, $req->id, $req->penerima);

          $botchat = DB::table("chatbot")->where("id", 1)->first();
          if ($botchat->is_active == "Y") {
            $now = Carbon::now('Asia/Jakarta');
            $time = $now->format('H:i');

            if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
              DB::table("listchat")
                ->insert([
                  'roomchat_id' => $req->id,
                  'account' => $req->penerima . "-" . $req->id,
                  'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
                  'created_at' => Carbon::now('Asia/Jakarta'),
                ]);
            }
          }

          $count = 0;
          $room = DB::table('roomchat')
               ->where("id", $req->id)
               ->first();
           // foreach ($chat as $key => $value) {
             $account = explode("-",$room->account);

             if ($account[0] != $req->id) {

               $count = $room->counter_satu;

               DB::table('roomchat')
                    ->where("id", $req->id)
                    ->update([
                      'last_message' => $req->message,
                      'counter_satu' => $count + 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);
             } else {

               $count = $room->counter_kedua;

               DB::table('roomchat')
                    ->where("id", $req->id)
                    ->update([
                      'last_message' => $req->message,
                      'counter_kedua' => $count + 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);
             }
           // }

         DB::commit();
    } catch (\Exception $e) {
         DB::rollback();
    }
  }

  public function aksesBot($idRoom, $idUser, $idPenerima) {
    $cekPromp = DB::table("listchat")
                  ->where('account', 'like', '%' . $idUser . "-" . '%')
                  ->orderBy("id", "desc")
                  ->first();

    $cekBot = DB::table("listchat")
                  ->where("roomchat_id", $idRoom)
                  ->orderBy("id", "desc")
                  ->first();

    $botAnswer = "";
    $topik = false;

    if($cekPromp->message == "/lama-proses") {
      $botAnswer = "Surat anda akan selesai diproses selama kurang lebih 15 hari kerja.";
    } else if($cekPromp->message == "/cara-ambil-surat") {
      $botAnswer = "Anda tidak perlu mengambil surat yang sudah jadi secara offline, cukup klik `Download` pada .... maka surat Anda siap dicetak";
    } else if($cekPromp->message == "/ajukan-kembalikan-surat") {
      $botAnswer = "Anda dapat mengajukan surat kembali dan pastikan dokumen persyaratan yang diperlukan sudah benar agar surat dapat diproses.";
    } else if($cekPromp->message == "/penyerahan-dokumen-fisik") {
      $botAnswer = "Tidak, Anda cukup menyerahkan dokumen digital dengan format PDF, PNG, JPG, JPEG.";
    } else if($cekPromp->message == "/topik") {
      $topik = true;
    }

    if ($topik == true || $botAnswer != "") {
      if($cekBot != null && $cekBot->is_bot == "N") {
        DB::table("listchat")
        ->insert([
          'roomchat_id' => $cekPromp->roomchat_id,
          'account' => $idPenerima . "-" . $idUser,
          'message' => $botAnswer,
          'is_topik' => $topik ? "Y" : "N",
          'is_bot' => "Y",
          'created_at' => Carbon::now('Asia/Jakarta'),
        ]);
      }
    } else {
      $botchat = DB::table("chatbot")->where("id", 1)->first();
      if ($botchat->is_active == "Y") {
        $now = Carbon::now('Asia/Jakarta');
        $time = $now->format('H:i');

        if ($time >= $botchat->jam_active && $time <= $botchat->jam_selesai) {
          DB::table("listchat")
            ->insert([
              'roomchat_id' => $idRoom,
              'account' => $idPenerima . "-" . $idUser,
              'message' => "Mohon maaf saat ini kami sedang offline, akan kita balas dijam aktif kami, terima kasih",
              'created_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }
      }
    }
  }
}
