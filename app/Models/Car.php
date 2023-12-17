<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;

class Car extends Model
{
    protected $table = 'car';

    public $fillable = [
        'merek',
        'model',
        'plat_no',
        'harga_sewa',
        'status',
    ];

    public function AddCar(Request $r){
        try{
            $data = $r->post();
            if(count($data) == 0) throw new Exception("Periksa kembali data kiriman anda",500);

            foreach($data as $key => $val){
                if(!in_array($key, $this->fillable)) unset($data[$key]);
            }

            if(count($data) < count($this->fillable)) throw new Exception("Periksa kembali data kiriman anda",500);

            $sql = $this->create($data);
            if(!isset($sql->id)) throw new Exception("Gagal Menyimpan Data Mobil",500);

            return [
                'status' => 1,
                'message' => "Berhasil Menyimpan Data Mobil",
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

    public function EditCar(Request $r){
        try{
            $data = $r->post();
            if(!isset($data['id'])) throw new Exception("Periksa kembali data kiriman anda",500);
            
            $id = $data['id'];
            // find data is exists
            $temp = $this->find($id);
            if(!$temp) throw new Exception("Data mobil tidak ditemukan",500);

            foreach($data as $key => $val){
                if(!in_array($key, $this->fillable)) unset($data[$key]);
            }

            if(count($data) < count($this->fillable)) throw new Exception("Periksa kembali data kiriman anda",500);

            if(isset($data['id'])) unset($data['id']);
            $sql = $this->where(['id' => $id])->update($data);

            if(!$sql) throw new Exception("Gagal Memperbaharui Data Mobil",500);

            return [
                'status' => 1,
                'message' => "Berhasil Memperbaharui Data Mobil",
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

    public function DelCar(Request $r){
        try{
            $data = $r->post();
            if(!isset($data['id'])) throw new Exception("Periksa kembali data kiriman anda",500);
            
            $id = $data['id'];
            // find data is exists
            $temp = $this->find($id);
            if(!$temp) throw new Exception("Data mobil tidak ditemukan",500);

            // generate password
            $sql = $this->where(['id' => $id])->delete();

            return [
                'status' => 1,
                'message' => "Berhasil Menghapus Data Mobil",
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
        
        $tmp_data = $this->orderBy('merek', 'ASC')->get();
        if(count($tmp_data) > 0) $data = $tmp_data->toArray();

        return $data;
    }

    public function GetById(Request $r){
        try{
            $data = $r->post();
            if(!isset($data['id'])) throw new Exception("Periksa kembali data kiriman anda",500);
            
            $id = $data['id'];
            // find data is exists
            $sql = $this->find($id);
            if(!$sql) throw new Exception("Data mobil tidak ditemukan",500);

            return [
                'status' => 1,
                'message' => "Berhasil Menghapus Data Mobil",
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

    public function GetCarReady(){
        try{
            $data = [];

            $sql = $this->where(['status' => 0])->get();
            if($sql->count() > 0) $data = $sql->toArray();

            return [
                'status' => 1,
                'message' => "Berhasil Mengambil Data Mobil",
                'code' => 200,
                'data' => $data
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
