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

class LoginPemohonController extends Controller
{

    public function __construct(){
        $this->middleware('guest');
    }

    public function index() {
        return view('auth.loginpemohon');
    }

    public function loginApi(Request $req) {
        $email = $req->email;
        $password = $req->password;
        $user = Account::where("email", $email)->where("role_id", "9")->first();
        // if ($user && Crypt::decryptString($user->password) ===  $req->password) {
        if ($user && Crypt::decryptString($user->password) ===  $req->email) {


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
            	if (Crypt::decryptString($user_pass->password) === $password) {

           			Account::where('email',$email)->update([
                     'updated_at'=>Carbon::now(),
                     'is_login' => "Y"
                 	  ]);

                   
                if ($user_pass->is_active == "Y") {
                  Auth::login($user);
                  // logController::inputlog('Login', 'Login', $username);
                  return Redirect('/home');
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
