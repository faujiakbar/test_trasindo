<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;

class Auth extends Model{
    protected $table = 'user';

    public $fillable = [
        'nama',
        'no_hp',
        'no_sim',
        'alamat',
        'hash_pwd',
    ];

    public function AddUser(Request $r){
        try{
            $data = $r->post();
            if(count($data) == 0) throw new Exception("Periksa kembali data kiriman anda",500);

            foreach($data as $key => $val){
                if(!in_array($key, $this->fillable)) unset($data[$key]);
            }

            if(count($data) < (count($this->fillable)-1)) throw new Exception("Periksa kembali data kiriman anda",500);

            // generate password
            $password = substr($data['nama'], -2, 2).substr($data['no_hp'], -2, 2).substr($data['no_sim'], -2, 2);
            $data["hash_pwd"] = Hash::make($password);
            $sql = $this->create($data);
            if(!isset($sql->id)) throw new Exception("Gagal Menyimpan Data Pengguna",500);

            $sql->{"password"} = $password;

            return [
                'status' => 1,
                'message' => "Berhasil Menyimpan Data Pengguna",
                'code' => 200,
                'data' => $sql
            ];
        } catch(Exception $e){
            return [
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function loginUser(Request $r){
        try{
            $data = $r->post();

            if(!isset($data['no_hp']) || !isset($data['password'])) throw new Exception("Periksa kembali data kiriman anda",500);

            $sql = $this->where(['no_hp' => $data['no_hp']])->first();

            if(!isset($sql->id)) throw new Exception("No. HP tidak ditemukan",500);

            if(!Hash::check($data['password'], $sql->hash_pwd)) throw new Exception("Kata sandi tidak sesuai",500);

            return [
                'status' => 1,
                'message' => "Berhasil login",
                'code' => 200,
                'data' => ['hash_pwd' => $sql->hash_pwd]
            ];
        } catch(Exception $e){
            return [
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }
}
