<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

class RegisterController extends Controller
{
    public function index() {
      return view("auth.register");
    }

    public function doregister(Request $req) {
      DB::beginTransaction();
      try {

        $fullname = $req->fullname;
        $email = $req->email;
        $nohp = $req->nohp;
        $username = $req->username;
        $password = $req->password;
        $confirmpass = $req->confirmpass;
        $term = $req->term;

        $codeverif = substr(str_shuffle("0123456789"), 0, 6);


        $cekemail = DB::table("user")->where("users_email", $email)->first();
        $cekusername = DB::table("user")->where("users_username", $username)->first();
        $ceknohp = DB::table("user")->where("users_nohp", $nohp)->first();

        $valid = true;
        if ($cekemail != null) {
          Session::flash('email','Email sudah terdaftar!');
          $valid = false;
        }

        if ($cekusername != null) {
          Session::flash('username','Username sudah terdaftar!');
          $valid = false;
        }

        if ($ceknohp != null) {
          Session::flash('nohp','Username sudah terdaftar!');
          $valid = false;
        }

        if ($password != $confirmpass) {
          Session::flash('password','Password confirm tidak sama!');
          $valid = false;
        }

        if ($term != "Y") {
            Session::flash('term','term untuk lanjut pendaftaran!');
            $valid = false;
        }

        if ($valid == false) {
          return back();
        } else {
          DB::table("user")
            ->insert([
              "users_name" => $fullname,
              "users_password" => sha1(md5('passwordAllah').$password),
              "users_username" => $username,
              "users_email" => $email,
              "users_nohp" => $nohp,
              "users_accesstoken" => md5(uniqid($username, true)),
              "users_codeverif" => $codeverif,
              "users_verification" => "N",
              "users_lastlogin" => Carbon::now('Asia/Jakarta'),
              "users_lastlogout" => Carbon::now('Asia/Jakarta'),
              "created_at" => Carbon::now('Asia/Jakarta'),
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);

          SendemailController::Send($fullname, "Your code verification : ".$codeverif."", 'Code Verification Register Account DompetQu', $email);

          $users = DB::table("user")
                    ->where("users_username", $username)
                    ->first();

          $id = $users->users_id;

          DB::commit();
          Session::flash('sukses','Berhasil');
          return view('auth.register', compact("id"));
        }

      } catch (\Exception $e) {
        DB::rollback();
        Session::flash('gagal','Gagal');
        return back();
      }

    }
}
