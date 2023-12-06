<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;


use Yajra\Datatables\Datatables;

class PemohonController extends Controller
{
    public function index() {
    // $roles = DB::table("role")->get();

      return view('pemohon.index');
    }

    public function datatable() {
      $data = DB::table('user')
        ->where("role_id",'like', '9')
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          // ->addColumn("nominal", function($data) {
          //   return FormatRupiah($data->uangkeluar_nominal);
          // })
         
          // ->addColumn("role", function($data) {
          //   $role = DB::table('role')->where('id', $data->role_id)->first();
          //   return $role->nama;
          // })
          ->addColumn('aksi', function ($data) {
            $buttons = '<div class="btn-group">'.
                            '<button type="button" onclick="approve('.$data->id.')" class="btn btn-success btn-lg" title="approve">'.
                            '<label class="fa fa-check"></label>'.
                        '</button>
                        <button type="button" onclick="tolak('.$data->id.')" class="btn btn-danger btn-lg" title="tolak">'.
                            '<label class="fa fa-times"></label>'.
                        '</button>
                            ';
        
            if ($data->is_active == "N") {
                // Tombol "Approve" hanya muncul jika is_active == 1
                $buttons .=  '<button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg" title="edit">'.
                '<label class="fa fa-eye"></label>'.
            '</button>';
            } else{
              $buttons = '<div class="btn-group"><button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg" title="edit">'.
              '<label class="fa fa-eye"></label>'.
          '</button>
          <button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
              '<label class="fa fa-trash"></label>'.
          '</button></div>
          ';
            }
        
            $buttons .= '</div>';
        
            return $buttons;
        })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
    }

    public function getData(Request $req){
      try{
        if($req->id){
          $data = DB::table('user')->where("id",$req->id)->first();
        }else{
          $data = DB::table('user')
             ->where("role_id",'like', '9')->get();
        }
  
        return response()->json(["status" => 1, "data" => $data]);
      }catch(\Exception $e){
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }

    public function simpan(Request $req) {
     
      if ($req->id == null) {
        DB::beginTransaction();
        try {
          $cekusername= DB::table("user")->where("username",$req->username)->first();
          $cekemail= DB::table("user")->where("email",$req->email)->first();

          if($cekemail !== null){
            return response()->json(["status" => 2, "message" => "Email Sudah Terdaftar"]);
          }else if($cekusername !== null){
            return response()->json(["status" => 2, "message" => "Username Sudah Digunakan"]);
          }
          else{
        DB::table("user")
              ->insertGetId([
              "nama_lengkap" => $req->nama_lengkap,
              "username" => $req->username,
              "email" => $req->email,
              "password" => $req->password,
              "role_id" => "9",
              "alamat" => $req->alamat,
              "provinsi" => $req->provinsi,
              "kabupaten_kota" => $req->kabupaten_kota,
              "kecamatan" => $req->kecamatan,
              "kelurahan" => $req->kelurahan,
              "jenis_kelamin" => $req->jenis_kelamin,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "tanggal_lahir" => $req->tanggal_lahir,
              "tempat_lahir" => $req->tempat_lahir,
              "pekerjaan" => $req->pekerjaan,
              "is_active" => "N",
              "created_at" => Carbon::now("Asia/Jakarta"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          DB::commit();
          return response()->json(["status" => 1,'message' => 'Berhasil Registrasi Tunggu Admin Mengaktivasi Akun Anda dan Mengirimkan Email'  ]);
          }
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
        
      } else {
        DB::beginTransaction();
        try {

          DB::table("user")
            ->where("id", $req->id)
            ->update([
              "nama_lengkap" => $req->nama_lengkap,
              "username" => $req->username,
              "email" => $req->email,
              "password" => encryptString$req->password,
              "alamat" => $req->alamat,
              "provinsi" => $req->provinsi,
              "kabupaten_kota" => $req->kabupaten_kota,
              "kecamatan" => $req->kecamatan,
              "kelurahan" => $req->kelurahan,
              "jenis_kelamin" => $req->jenis_kelamin,
              "jenis_identitas" => $req->jenis_identitas,
              "nomor_identitas" => $req->nomor_identitas,
              "tanggal_lahir" => $req->tanggal_lahir,
              "tempat_lahir" => $req->tempat_lahir,
              "pekerjaan" => $req->pekerjaan,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

         
          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4, "message" =>$e->getMessage()]);
        }
      }

    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("user")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function tolak(Request $req) {
      $data = DB::table("user")
              ->where("id", $req->id)
              ->first();

      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function tolakprocess(Request $req) {
      DB::beginTransaction();
      try {
        $data = DB::table("user")
        ->where("id", $req->id)
        ->first();
        SendemailController::Send($data->nama_lengkap,"Alasan : ".$req->alasan_ditolak." . Silahkan lakukan Registrasi Kembali dengan data yang sesuai", "Akun Anda Gagal Diaktifkan",  $data->email);

        DB::table("user")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 1]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, 'error' => $e->getMessage()]);
      }

    }

    public function approve(Request $req) {
      DB::beginTransaction();
      try {
        $data = DB::table("user")
        ->where("id", $req->id)
        ->first();

        DB::table("user")
            ->where("id", $req->id)
            ->update([
              "is_active" => "Y"
            ]);
            
            SendemailController::Send($data->nama_lengkap, "Silahkan Login ke akun anda","Selamat Akun Anda Sudah di Aktivasi", $data->email);
        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("user")
              ->where("id", $req->id)
              ->first();

      $petugas = [
        "id" => $data->id,
        "nama_lengkap" => $data->nama_lengkap,
        "username" => $data->username,
      ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($petugas);
    }
}
