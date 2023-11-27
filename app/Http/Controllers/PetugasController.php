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

class PetugasController extends Controller
{
    public function index() {
    $roles = DB::table("role")->get();

      return view('petugas.index', compact('roles'));
    }

    public function datatable() {
      $data = DB::table('user')
        ->where("role_id",'not like', '9')
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          // ->addColumn("nominal", function($data) {
          //   return FormatRupiah($data->uangkeluar_nominal);
          // })
          ->addColumn("password", function($data) {
            $encrypted = Crypt::encryptString('adminutama123');
		$decrypted = Crypt::decryptString($data->password);
            return $decrypted;
          })
          ->addColumn("role", function($data) {
            $role = DB::table('role')->where('id', $data->role_id)->first();
            return $role->nama;
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
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
             ->where("role_id",'not like', '9')->get();
        }
  
        return response()->json(["status" => 1, "data" => $data]);
      }catch(\Exception $e){
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }

    public function simpan(Request $req) {
      $nominal = str_replace("Rp. ", "", $req->nominal);
      $nominal = str_replace(".", "", $nominal);
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        DB::table("user")
              ->insertGetId([
              "nama_lengkap" => $req->nama_lengkap,
              "username" => $req->username,
              "password" => Crypt::encryptString($req->password),
              "role_id" => $req->role,
              "is_active" => "Y",
              "created_at" => Carbon::now("Asia/Jakarta"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
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
              "password" => Crypt::encryptString($req->password),
              "role_id" => $req->role,
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

    public function edit(Request $req) {
      $data = DB::table("user")
              ->where("id", $req->id)
              ->first();

      $petugas = [
        "id" => $data->id,
        "nama_lengkap" => $data->nama_lengkap,
        "username" => $data->username,
        "password" => Crypt::decryptString($data->password),
        "role_id" => $data->role_id,
      ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($petugas);
    }
}
