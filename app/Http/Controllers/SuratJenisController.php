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

class SuratJenisController extends Controller
{
    public function index() {

      return view('surat-jenis.index');
    }

    public function datatable() {
      $data = DB::table('surat_jenis')
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          // ->addColumn("nominal", function($data) {
          //   return FormatRupiah($data->uangkeluar_nominal);
          // })
         
          ->addColumn("surat_syarat", function($data) {
           return '<div class="btn-group">'.
            '<a href="surat-syarat?id='.$data->id.'" class="btn btn-success btn-lg px-4 py-2" title="edit">'.
            'Lihat Syarat</a>
         </div>';
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi', 'surat_syarat'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function simpan(Request $req) {
     
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        DB::table("surat_jenis")
              ->insertGetId([
              "nama" => $req->nama,
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

          DB::table("surat_jenis")
            ->where("id", $req->id)
            ->update([
              "nama" => $req->nama,
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

        DB::table("surat_jenis")
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
      $data = DB::table("surat_jenis")
              ->where("id", $req->id)
              ->first();

      // $petugas = [
      //   "id" => $data->id,
      //   "nama_lengkap" => $data->nama_lengkap,
      //   "username" => $data->username,
      //   "password" => Crypt::decryptString($data->password),
      //   "role_id" => $data->role_id,
      // ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }
}
