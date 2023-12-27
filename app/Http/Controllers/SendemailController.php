<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendemailController extends Controller
{
    public static function Send($nama, $pesan, $deskripsi, $email) {
        try {
            Mail::send([], [], function ($message) use ($email, $deskripsi, $nama, $pesan) {
                $message->subject($deskripsi);
                $message->from('epicapps@gmail.com', 'Epic');
                $message->to($email);

                // Tambahkan konten HTML dan teks biasa
                $message->setBody($pesan, 'text/plain');
                $message->addPart($pesan, 'text/html');

                // Atau gunakan metode view untuk email blade
                // $message->view('emails.email_template', ['nama' => $nama, 'deskripsi' => $deskripsi, 'pesan' => $pesan]);
            });

            return true;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }
}
