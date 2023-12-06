<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Account;

use App\Authentication;

// use Auth;

use Carbon\Carbon;

// use Session;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {

    //    $uangkeluar = DB::table("uangkeluar")->where("uangkeluar_users_id", Auth::user()->users_id)->whereMonth("created_at", date('m'))->whereYear("created_at", date('Y'))->sum("uangkeluar_nominal");

    //    $tagihan = DB::table("daftar_tagihan")->join('tagihan','tagihan_id','=','daftar_tagihan_tagihan_id')->where("tagihan_users_id", Auth::user()->users_id)->where("daftar_tagihan_bayar", "N")->whereMonth("daftar_tagihan.created_at", date('m'))->whereYear("daftar_tagihan.created_at", date('Y'))->sum("tagihan_nominal");

    //    $saldo = SaldoController::ceksaldo();

       return view("pages.dashboard");
     }

    public function logout(){
        $role = Auth::user()->role_id;
        Session::flush();
        Account::where('id', Auth::user()->id)->update([
             'updated_at' => Carbon::now('Asia/Jakarta'),
             'is_login' => "N"
            //  "users_accesstoken" => md5(uniqid(Auth::user()->users_username, true)),
        ]);

        // Account::where('m_id', Auth::user()->m_id)->update([
        //      'm_statuslogin' => 'N'
        //     ]);

        // logController::inputlog('Logout', 'Logout', Auth::user()->m_username);
        Auth::logout();

        Session::forget('key');
        
        if($role == "9") {
            return Redirect('/');
        } else {
            return Redirect('/');
        }
    }
}
