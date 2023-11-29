<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

class ChatbotController extends Controller
{

     public function index() {

       $data = DB::table("chatbot")
         ->where('id', 1)->first();

         if ($data == null) {
           return view("chatbot.index");
         } else {
           return view("chatbot.index", compact("data"));
         }
     }

     public function save(Request $req) {
       DB::beginTransaction();
       try {

            $data = DB::table("chatbot")->get();

            if ($req->is_active == true) {
                $active = true;
            } else {
                $active = false;
            }

            if (count($data) != 0) {
                DB::table("chatbot")
                    ->where('id', 1)
                    ->update([
                    'is_active' => $active,
                    'jam_active' => $req->date,
                    'jam_selesai' => $req->enddate,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                    'updated_at' => Carbon::now('Asia/Jakarta')
                  ]);
            } else {
              DB::table("chatbot")
                ->insert([
                  'is_active' => $active,
                  'jam_active' => $req->date,
                  'jam_selesai' => $req->enddate,
                  'created_at' => Carbon::now('Asia/Jakarta'),
                  'updated_at' => Carbon::now('Asia/Jakarta')
                ]);
            }

            DB::commit();
            Session::flash('sukses', 'sukses');

            return back()->with('sukses','sukses');
       } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'gagal');

            return back()->with('gagal','gagal');
       }

     }
}
