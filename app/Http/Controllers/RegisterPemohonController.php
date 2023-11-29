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
        return view("auth.registerpemohon", compact("email", "nama"));
      } else {
        return view("auth.registerpemohon");
      }
    }

    public function register(Request $req) {
      DB::beginTransaction();
      try { 
        $cekemail = DB::table("user")->where("email", $req->email)->first();
        $ceknohp = DB::table("user")->where("no_telp", $req->no_telp)->first();

        $valid = true;
        if ($cekemail != null) {
          Session::flash('email','Email sudah terdaftar!');
          $valid = false;
        }

        if ($ceknohp != null) {
          Session::flash('nohp','Username sudah terdaftar!');
          $valid = false;
        }

        if ($req->password != $req->konfirmasi_password) {
          Session::flash('password','Password confirm tidak sama!');
          $valid = false;
        }

        if ($req->tanggal_lahir == null) {
          Session::flash('tanggal_lahir','Tanggal lahir kosong!');
          $valid = false;
        }
        
        if ($valid == false) {
          return back();
        } else {
          DB::table("user")
            ->insert([
              "role_id" => "9",
              "password" => Crypt::encryptString($req->password),
              "email" => $req->email,
              "nama_lengkap" => $req->nama_lengkap,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "jenis_kelamin" => $req->jenis_kelamin,
              "tempat_lahir" => $req->tempat_lahir,
              "tanggal_lahir" => Carbon::parse($req->tanggal_lahir)->format("d M y"),
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
          Session::flash('sukses','Berhasil');
          return back();
        }

      } catch (\Exception $e) {
        DB::rollback();
        Session::flash('gagal','Gagal');
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
              "password" => Crypt::encryptString($req->password),
              "email" => $req->email,
              "nama_lengkap" => $req->nama_lengkap,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "jenis_kelamin" => $req->jenis_kelamin,
              "tempat_lahir" => $req->tempat_lahir,
              "tanggal_lahir" => Carbon::parse($req->tanggal_lahir)->format("d M y"),
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
          return response()->json(["status" => 1]);
        }

      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" =>$e->getMessage()]);
      }
    }
}
