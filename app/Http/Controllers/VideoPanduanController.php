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

class VideoPanduanController extends Controller
{
    public function index() {

      return view('video-panduan.index');
    }

    public function datatable() {
      $data = DB::table('video_panduan')
        ->get();


        
        return Datatables::of($data)
        
         
          ->addColumn("url", function($data) {
           return '<div class="btn-group">'.
            '<a href='.$data->url.' class="btn btn-success btn-lg px-4 py-2" title="Lihat Video" target="_blank">'.
            'Lihat Video</a>
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
          ->rawColumns(['aksi','url'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function simpan(Request $req) {
     
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        DB::table("video_panduan")
              ->insertGetId([
              "nama" => $req->nama,
              "url" => $req->url,
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

          DB::table("video_panduan")
            ->where("id", $req->id)
            ->update([
              "nama" => $req->nama,
              "url" => $req->url,
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

        DB::table("video_panduan")
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
      $data = DB::table("video_panduan")
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
