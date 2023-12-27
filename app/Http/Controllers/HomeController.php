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

    $currentYear = now()->year;

    $linechart = DB::table('surat')
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "Selesai" THEN 1 ELSE 0 END) as total_diterbitkan'),
            DB::raw('SUM(CASE WHEN status = "Ditolak" THEN 1 ELSE 0 END) as total_ditolak'),
            DB::raw('SUM(CASE WHEN status != "Ditolak" AND status != "Selesai" THEN 1 ELSE 0 END) as total_masuk'),
        )
        ->whereYear('created_at', $currentYear)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();
       return view("pages.dashboard",compact('linechart'));
     }

    public function logout(){
        $role = Auth::user()->role_id;
        Session::flush();
        Account::where('id', Auth::user()->id)->update([
             'updated_at' => Carbon::now('Asia/Jakarta'),
             'is_login' => "N"
        ]);

        Auth::logout();

        Session::forget('key');
        
        if($role == "9") {
            return Redirect('/');
        } else {
            return Redirect('/');
        }
    }
}
