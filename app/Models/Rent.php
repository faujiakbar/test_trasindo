<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// load library
use Illuminate\Http\Request;

// load Models
use App\Models\{
        Car,
        Auth
    };

class Rent extends Model
{
    protected $table = 'rent';

    public $fillable = [
        'id_car',
        'rent_start',
        'rent_end',
        'id_user',
    ];

    public function car(){
        return $this->belongsTo(Car::class,'id_car', 'id');
    }

    public function AddRent(Request $r){
        try{
            $data = $r->post();
            if(count($data) == 0) throw new Exception("Periksa kembali data kiriman anda",500);

            // get data user
            $user = Auth::where(['hash_pwd' => $data['hash']])->first();
            if(!$user) throw new Exception("Pengguna tidak ditemukan",500);

            $data['id_user'] = $user->id;

            foreach($data as $key => $val){
                if(!in_array($key, $this->fillable)) unset($data[$key]);
            }

            if(count($data) < count($this->fillable)) throw new Exception("Periksa kembali data kiriman anda",500);

            $sql = $this->create($data);
            if(!isset($sql->id)) throw new Exception("Gagal Memproses Pinjaman Mobil",500);

            // update status car to 1
            Car::where(["id" => $sql->id_car])->update(['status' => 1]);

            return [
                'status' => 1,
                'message' => "Berhasil Memproses Pinjaman Mobil",
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

    public function GetAll(){
        $data = [];
        
        $tmp_data = $this->with(['car'])->orderBy('rent_start', 'DESC')->get();
        if(count($tmp_data) > 0) $data = $tmp_data->toArray();

        return $data;
    }
}
