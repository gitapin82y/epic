<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Yajra\Datatables\Datatables;

class HasilKepuasanController extends Controller
{
    public function index() {
        return view('hasil-kepuasan.index');
    }

    public function datatable() {
        $data = DB::table('ulasan')
        ->select('created_at','ulasan_hasil_id', DB::raw('count(*) as total'))
        ->groupBy('created_at', 'ulasan_hasil_id')
        ->orderBy('created_at', 'DESC')
        ->get();
        

          return Datatables::of($data)
          ->addColumn("nama_lengkap", function($data) {
            $user =  DB::table('user')->find($data->ulasan_hasil_id);
            return $user->nama_lengkap;
          })
          ->addColumn("created_at", function($data) {
            return Carbon::parse($data->created_at)->format('d F Y');
          })
            ->addColumn('aksi', function ($data) {
              return  '<a href="javascript:void(0)" onclick="edit('.$data->ulasan_hasil_id.')" class="btn btn-success btn-lg pt-2" title="show" id="showModalLink">'.
                       '<label class="fa fa-eye w-100"></label></a>';
            })
            ->rawColumns(['nama_lengkap','created_at','aksi'])
            ->addIndexColumn()
            // ->setTotalRecords(2)
            ->make(true);
      }

      public function detail(Request $req){
        $ulasanData = DB::table('ulasan')
            ->join('ulasan_pertanyaan', 'ulasan.ulasan_pertanyaan_id', '=', 'ulasan_pertanyaan.id')
            ->select('ulasan.id', 'ulasan_pertanyaan.nama', 'ulasan.isi')
            ->where('ulasan.ulasan_hasil_id','=',$req->ulasan_hasil_id)
            ->get();
        return response()->json($ulasanData);
      }
}
