<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Auth;

class Account extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable,
        CanResetPassword;

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    protected $fillable = ["id", "role_id", "username", "password", "email", "nama_lengkap", "jenis_identitas", "nomor_identitas", "jenis_kelamin", "tempat_lahir", "tanggal_lahir", "provinsi", "kabupaten_kota", "kecamatan", "kelurahan", "alamat", "no_telp", "pekerjaan", "is_login", "is_active", "created_at", "updated_at"];


    

}
