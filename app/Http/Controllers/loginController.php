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
            if($user->role_id == 9){
                if(md5($password) == $user->password ){
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
            }else{
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
            }
        } else {
            return response()->json([
                        'status' => 3,
                        'message' => 'akun tidak ditemukan'
            ]);
        }
    }catch (\Exception $e) {
        return response()->json(["status" => 2, "message" =>$e->getMessage()]);
    }
    }
    

    public function authenticate(Request $req) {

        $rules = array(
            'email' => 'required|min:3', // make sure the email is an actual email
            'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
        );
        $pesan = array(
            'email.required' => 'Email wajib diisi.',
            'email.min' => 'Panjang email minimal :min karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Panjang password minimal :min karakter.',
        );
    	// dd($req->all());
        $validator = Validator::make($req->all(), $rules, $pesan);
        if ($validator->fails()) {
            return Redirect('/admin')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($req->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $email  = $req->email;
            $password  = $req->password;
            // $encrypt = Crypt::encryptString('adminutama123');
            
           	// $pass_benar=md5($password);
            // $pass_benar=$password;
            // $username = str_replace('\'', '', $username);

            $user = Account::where("email", $email)->first();

            $user_valid = [];
            // dd($req->all());

           	if ($user != null) {
           		$user_pass = Account::where('email',$email)
	            			        //   ->where('password',$encrypt)
	            			          ->first();

            	// if (Crypt::decryptString($user_pass->password) === $password) {
            	if ($user_pass->password === $password) {

           			Account::where('email',$email)->update([
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
                return back()->with('password','email');
            	}
           	}else{
           		Session::flash('email','Email Tidak Ada');
           		return back()->with('password','email');
           	}


        }
    }

    public function logout(Request $req) {
        try {
            //code...
            DB::table("user")
            ->where("id", $req->id)
            ->update([
                "is_login" => "N"
            ]);
            return response()->json([
                'status' => 1,
    ]);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'status' => 2,
                'message' => $e->getMessage(),
    ]);
        }
       
    }

    public function getProfil(Request $req) {
        try {
            //code...
          $pemohon =   DB::table("user")
            ->where("id", $req->id)->first();

            $role = DB::table('role')->where('id', $pemohon->role_id)->first();

            return response()->json([
                'status' => 1,
                'data' => [
                    'user' => $pemohon,
                    'role' => $role
                ]
    ]);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'status' => 2,
                'message' => $e->getMessage(),
    ]);
        }
      
        // ->update([
        //     "SubID" => null
        // ]);
    }

}
