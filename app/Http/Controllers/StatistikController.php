<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

class StatistikController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {
       return view("statistik.index");

     }

     public function get(Request $req) {

       $date = $req->date;
       $month = 1;
       $tagihanvalue = [];
       $masukvalue = [];
       $keluarvalue = [];

       for ($i=1; $i <= 12; $i++) {
         $tmptagihan = DB::table("daftar_tagihan")->whereMonth("created_at", "0".$i)->whereYear('created_at', $date)->orderBy("daftar_tagihan_id", "desc")->get();
         $tmpmasuk = DB::table("uangmasuk")->where("uangmasuk_users_id", Auth::user()->users_id)->whereMonth("created_at", "0".$i)->whereYear('created_at', $date)->orderBy("uangmasuk_id", "desc")->sum("uangmasuk_nominal");
         $tmpkeluar = DB::table("uangkeluar")->where("uangkeluar_users_id", Auth::user()->users_id)->whereMonth("created_at", "0".$i)->whereYear('created_at', $date)->orderBy("uangkeluar_id", "desc")->sum("uangkeluar_nominal");

         if (count($tmptagihan) == 0) {
           $tagihanvalue[$month - 1] = 0;
           $masukvalue[$month - 1] = (Int)$tmpmasuk;
           $keluarvalue[$month - 1] = (Int)$tmpkeluar;
         } else {
           foreach ($tmptagihan as $key => $value) {
             $tagihanvalue[$month - 1] = 0;
             $tmpmastertagihan = DB::table("tagihan")->where("tagihan_users_id", Auth::user()->users_id)->where("tagihan_id", $value->daftar_tagihan_tagihan_id)->first();

             if ($tmpmastertagihan == null) {
               $tagihanvalue[$month - 1] += 0;
             } else {
               $tagihanvalue[$month - 1] += $tmpmastertagihan->tagihan_nominal;
             }


           }

           $masukvalue[$month - 1] = (Int)$tmpmasuk;
           $keluarvalue[$month - 1] = (Int)$tmpkeluar;
         }

         $month += 1;
       }

       return response()->json([
         'tagihanvalue' => $tagihanvalue,
         'masukvalue' => $masukvalue,
         'keluarvalue' => $keluarvalue
       ]);
     }
}
