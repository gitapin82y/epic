<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use Response;

class PushNotifController extends Controller
{
    public static function sendMessage($userid, $title, $message) {
        $heading = array(
            "en" => $title
         );

        $content = array(
            "en" => $message
        );
    
        $fields = array(
            'app_id' => "78f36c43-942f-46e4-a155-aab7ecfdf1cc",
            'included_segments' => array('All'),
            'data' => array("userid" => $userid),
            'contents' => $content,
            'headings' => $heading
        );
    
        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                    'Authorization: Basic OThkYjkyY2EtODI2ZC00NGU2LTk4ZTYtMDM2MmRiZmQ1ZDU0'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    
        // $response = curl_exec($ch);
        curl_close($ch);

        DB::table("notifikasi")
        ->insert([
            "user_id" => $userid,
            "judul" => $title,
            "deskripsi" => $message,
            "is_seen" => "N",
            "created_at" => Carbon::now('Asia/Jakarta'),
            "updated_at" => Carbon::now('Asia/Jakarta'),
          ]);
    
        // return $response;
    }
}
