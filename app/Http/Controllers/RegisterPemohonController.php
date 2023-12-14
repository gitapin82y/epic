<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use Illuminate\Support\Facades\Crypt;

class RegisterPemohonController extends Controller
{
    public function index(Request $req) {
      if ($req->fullname != null) {
        $nama = $req->fullname;
        $email = $req->email;
        return view("login-system.register", compact("email", "nama"));
      } else {
        return view("login-system.register");
      }
    }

    public function register(Request $req) {
      DB::beginTransaction();
      try { 

        $cekemail = DB::table("user")->where("email", $req->email)->first();
        // $ceknohp = DB::table("user")->where("no_telp", $req->no_telp)->first();

        $valid = true;
        if ($cekemail != null) {
          Session::flash('email','Email sudah terdaftar!');
          $valid = false;
        }

        // if ($ceknohp != null) {
        //   Session::flash('nohp','Username sudah terdaftar!');
        //   $valid = false;
        // }

        if ($req->password != $req->konfirmasi_password) {
          Session::flash('password','Password confirm tidak sama!');
          $valid = false;
        }

        if ($req->tanggal_lahir == null) {
          Session::flash('tanggal_lahir','Tanggal lahir kosong!');
          $valid = false;
        }

        if ($req->no_telp == null) {
          Session::flash('no_telp','Nomor telepon kosong!');
          $valid = false;
        }

        if ($req->alamat == null) {
          Session::flash('alamat','Aalamat kosong!');
          $valid = false;
        }

        if ($req->tempat_lahir == null) {
          Session::flash('tempat_lahir','Tempat lahir kosong!');
          $valid = false;
        }


        if ($req->jenis_kelamin == null) {
          Session::flash('jenis_kelamin','Jenis kelamin kosong!');
          $valid = false;
        }

        if ($req->nomor_identitas == null) {
          Session::flash('nomor_identitas','Nomor identitas kosong!');
          $valid = false;
        }

        if ($req->pekerjaan == null) {
          Session::flash('pekerjaan','Pekerjaan kosong!');
          $valid = false;
        }

        if ($req->jenis_identitas == null) {
          Session::flash('jenis_identitas','Nomor identitas kosong!');
          $valid = false;
        }

        if ($valid == false) {
          Session::flash('gagalLogin','gagalLogin');
          return back();
        } else {
          $apin = DB::table("user")
            ->insert([
              "role_id" => "9",
              "password" => md5($req->password),
              "email" => $req->email,
              "username" => explode('@', $req->email)[0],
              "nama_lengkap" => $req->nama_lengkap,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "jenis_kelamin" => $req->jenis_kelamin,
              "tempat_lahir" => $req->tempat_lahir,
              "tanggal_lahir" => Carbon::parse($req->tanggal_lahir)->format("Y-m-d"),
              "provinsi" => $req->provinsi,
              "kabupaten_kota" => $req->kabupaten_kota,
              "kecamatan" => $req->kecamatan,
              "kelurahan" => $req->kelurahan,
              "alamat" => $req->alamat,
              "no_telp" => $req->no_telp,
              "pekerjaan" => $req->pekerjaan,
              "is_active" => "Y",
              "created_at" => Carbon::now('Asia/Jakarta'),
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);
            
          DB::commit();
          Session::flash('berhasilLogin','berhasilLogin');
          return redirect('loginpemohon');
        }

      } catch (\Exception $e) {
        DB::rollback();
        return dd($e);
        Session::flash('gagalLogin','gagalLogin');
        return back();
      }
    }

    public function apiregister(Request $req) {
      DB::beginTransaction();
      try { 
        $cekemail = DB::table("user")->where("email", $req->email)->first();
        $ceknohp = DB::table("user")->where("no_telp", $req->no_telp)->first();
        $message = "";

        $valid = true;
        if ($cekemail != null) {
          $message = 'Email sudah terdaftar!';
          $valid = false;
        }

        if ($ceknohp != null) {
          $message = 'Username sudah terdaftar!';
          $valid = false;
        }

        if ($req->password != $req->konfirmasi_password) {
          $message = 'Password confirm tidak sama!';
          $valid = false;
        }

        if ($req->tanggal_lahir == null) {
          $message = 'Tanggal lahir kosong!';
          $valid = false;
        }
        
        if ($valid == false) {
          return response()->json(["status" => 2, "message" => $message]);
        } else {
          DB::table("user")
            ->insert([
              "role_id" => "9",
              "password" => md5($req->password),
              "email" => $req->email,
              "nama_lengkap" => $req->nama_lengkap,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "jenis_kelamin" => $req->jenis_kelamin,
              "tempat_lahir" => $req->tempat_lahir,
              "tanggal_lahir" => Carbon::parse($req->tanggal_lahir)->format("Y-m-d"),
              "provinsi" => $req->provinsi,
              "kabupaten_kota" => $req->kabupaten_kota,
              "kecamatan" => $req->kecamatan,
              "kelurahan" => $req->kelurahan,
              "alamat" => $req->alamat,
              "no_telp" => $req->no_telp,
              "pekerjaan" => $req->pekerjaan,
              "is_active" => "Y",
              "created_at" => Carbon::now('Asia/Jakarta'),
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);
            
          DB::commit();
          return response()->json(["status" => 1, 'message' => 'Berhasil Registrasi , Selamat Datang di Epic' ]);
        }

      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" =>$e->getMessage()]);
      }
    }
}
