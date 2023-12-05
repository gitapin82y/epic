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

class loginController extends Controller
{

    public function __construct(){
        $this->middleware('guest');
    }

    public function admin() {
        return view('login-system.login');
    }

    public function loginApi(Request $req) {
        $email = $req->email;
        $password = $req->password;
        // if ($user && Crypt::decryptString($user->password) ===  $req->password) {
        try{
        $user = Account::where("email", $email)->first();

            if ($user) {
                if($user->password ===  $req->password){
                $role = DB::table('role')->where('id', $user->role_id)->first();
            return response()->json([
                        'status' => 1,
                        'message' => 'success login',
                        'data' => [
                            'user' => $user,
                            'role' => $role
                        ]
            ]);
        }else{
            return response()->json([
                'status' => 2,
                'message' => 'password yang anda masukkan salah'
    ]);
        }
        } else {
            return response()->json([
                        'status' => 2,
                        'message' => 'akun tidak ditemukan'
            ]);
        }
    }catch (\Exception $e) {
        return response()->json(["status" => 2, "message" =>$e->getMessage()]);
    }
    }
    

    public function authenticate(Request $req) {

        $rules = array(
            'username' => 'required|min:3', // make sure the email is an actual email
            'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
        );
    	// dd($req->all());
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Redirect('/')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($req->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $username  = $req->username;
            $password  = $req->password;
            // $encrypt = Crypt::encryptString('adminutama123');
            
           	// $pass_benar=md5($password);
            // $pass_benar=$password;
            // $username = str_replace('\'', '', $username);

            $user = Account::where("username", $username)->first();

            $user_valid = [];
            // dd($req->all());

           	if ($user != null) {
           		$user_pass = Account::where('username',$username)
	            			        //   ->where('password',$encrypt)
	            			          ->first();

            	// if (Crypt::decryptString($user_pass->password) === $password) {
            	if ($user_pass->password === $password) {

           			Account::where('username',$username)->update([
                     'updated_at'=>Carbon::now(),
                     'is_login' => "Y"
                 	  ]);

                   
                if ($user_pass->is_active == "Y") {
                  Auth::login($user);
                  // logController::inputlog('Login', 'Login', $username);
                  return Redirect('/home');
                // return view('pages.dashboard');
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

}
