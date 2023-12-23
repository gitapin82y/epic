<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Http\Controllers\logController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginPemohonController extends Controller
{

    public function __construct(){
        $this->middleware('guest');
    }

    public function lupa() {
        return view('login-system.lupa');
    }

    public function changepassword(Request $req) {
        if ($req->otp != null) {
            $data = DB::table("user")
                    ->where("otp", $req->otp)
                    ->where("email", $req->email)
                    ->first();

            return view('login-system.changepassword', compact("data"));
         }
    }
    
    public function dochangepassword(Request $req) {
        $data = DB::table("user")
                ->where("otp", $req->otp)
                ->where("email", $req->email)
                ->first();

        if ($req->password == $req->confirmpassword) {
            DB::table("user")
            ->where("otp", $req->otp)
            ->where("email", $req->email)
            ->update([
                "password" => $req->password
            ]);

            return redirect('loginpemohon');
        } else {
            Session::flash('password', "password tidak sama");
            return view('login-system.changepassword', compact("data"));
        }
    } 

    public function apidochangepassword(Request $req) {
        if ($req->password == $req->confirmpassword) {
            DB::table("user")
            ->where("email", $req->email)
            ->update([
                "password" => $req->password
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'Password tidak sama!',
            ]);
        }
    } 

    public function apidolupa(Request $req) {
        $data = DB::table("user")
                    ->where("email", $req->email)
                    ->first();

        if($data == null) {
            return response()->json([
                'status' => 2,
                'message' => 'email tidak ada!',
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'email ditemukan!',
            ]);
        }
    }

    public function dolupa(Request $req) {
        $data = DB::table("user")
                    ->where("email", $req->email)
                    ->first();

        if($data == null) {
            Session::flash('email','Email Tidak Ada');
            return Redirect('/lupapassword');
        } else {
            $this->sendOTP($data->nama_lengkap, $data->email);
            Session::flash('showmodal',$data->email);
            return Redirect('/lupapassword');
        }
    }

    public function dosendotp(Request $req) {
        $data = DB::table("user")
                    ->where("email", $req->email)
                    ->first();

        $this->sendOTP($data->nama_lengkap, $req->email);
    }

    public function confirmotp(Request $req) {
        $data = DB::table("user")
                ->where("otp", $req->otp)
                ->first();

        if($data != null) {
            return response()->json([
                'status' => 1,
                'message' => 'success otp',
            ]);
        } else {
            return response()->json([
                'status' => 2,
                'message' => 'gagal otp',
            ]);
        }
    }

    public function sendOTP($nama, $email) {

        $digits = 4;
        $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        DB::table("user")
            ->where("otp", strval($otp))
            ->update([
                "otp" => ""
            ]);

        DB::table("user")
            ->where("email", $email)
            ->update([
                "otp" => $otp
            ]);

        SendemailController::Send($nama, "Code OTP Ganti Password Anda : " . $otp, "Silahkan Masukkan Code OTP untuk mengganti password anda!",  $email);

        return response()->json([
            'status' => 1,
            'message' => 'success otp',
        ]);
    }

    public function index() {
        return view('login-system.loginpemohon');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        dd($user);
        $findUser = Account::where("email", $user->email)->where("role_id", "9")->first();

        if ($findUser != null) {
            Auth::login($findUser);
            return redirect('/');
        } else {
            // return response()->json(2);
            return redirect('/registerpemohon?fullname='.$user->name.'&email='.$user->email);
        }
        // Proses login atau registrasi pengguna di sini
    }

    public function apigoogle(Request $req) {
        $findUser = Account::where("email", $req->email)->first();

        if ($findUser != null) {
            $role = DB::table('role')->where('id', $findUser->role_id)->first();

            return response()->json([
                'status' => 1,
                'message' => 'success login',
                'data' => [
                    'user' => $findUser,
                    'role' => $role
                ]
            ]);
        } else {
            return response()->json([
                'status' => 2,
                'success' => 'belum register',
            ]);
        }
    }

    public function loginApi(Request $req) {
        $email = $req->email;
        $password = $req->password;
        $user = Account::where("email", $email)->where("role_id", "9")->first();
        // if ($user && Crypt::decryptString($user->password) ===  $req->password) {
        if ($user && $user->password ===  $req->email) {


            return response()->json([
                        'success' => 'succes',
                        'data' => $user
            ]);
        } else {
            return response()->json([
                        'success' => 'gagal',
            ]);
        }
    }
    

    public function authenticate(Request $req) {
        $rules = array(
            'email' => 'required|min:3', // make sure the email is an actual email
            'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
        );
    	// dd($req->all());
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Redirect('/loginpemohon')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($req->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $email  = $req->email;
            $password  = $req->password;
            // $encrypt = Crypt::encryptString('adminutama123');
            
           	// $pass_benar=md5($password);
            // $pass_benar=$password;
            // $username = str_replace('\'', '', $username);

            $user = Account::where("email", $email)->where("role_id", "9")->first();

           
            $user_valid = [];
            // dd($req->all());

           	if ($user != null) {
           		$user_pass = Account::where('email',$email)
	            			        //   ->where('password',$encrypt)
	            			          ->first();

            	// if (Crypt::decryptString($user_pass->password) === $password) {
            	if ($req->password == $user->password) {

           			Account::where('email',$email)->update([
                     'updated_at'=>Carbon::now(),
                     'is_login' => "Y"
                 	  ]);

                   
                if ($user_pass->is_active == "Y") {
                  Auth::login($user);
                  // logController::inputlog('Login', 'Login', $username);
                  return Redirect('/');
                } else {
                  $id = $user_pass->id;
                  return redirect("/verification/".encrypt($id)."");
                }
            	}else{
                Session::flash('password','Password Yang Anda Masukan Salah!');
                return back()->with('password','username');
            	}
           	}else{
           		Session::flash('username','Username Tidak Ada');
           		return back()->with('password','username');
           	}


        }
    }

    public function google(Request $req) {
        $user = Account::where("email", $req->email)->where("role_id", "9")->first();

        if ($user != null) {
            Auth::login($user);
            return response()->json(1);
        } else {
            return response()->json(2);
        }
    }

}
