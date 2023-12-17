<?php
namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;

// load library
use Illuminate\Http\Request;
use Illuminate\View\View;

// load Helpers
use App\Helpers\Mailer;

// load Models
use App\Models\Car;

class CarController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function CarManage(Request $r){
        $data = [];

        return View('car.manage',$data);
    }

    public function CarRent(Request $r){
        $data = [];

        return View('car.rent',$data);
    }

    public function CarWithdraw(Request $r){
        $data = [];

        return View('car.withdraw',$data);
    }

    public function AddCar(Request $r){
        $data = [];

        $return = (new Car)->AddCar($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function EditCar(Request $r){
        $data = [];

        $return = (new Car)->EditCar($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function DelCar(Request $r){
        $data = [];

        $return = (new Car)->DelCar($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function GetById(Request $r){
        $data = [];

        $return = (new Car)->GetById($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function GetAllCar(Request $r){
        $data = [];

        $return = (new Car)->GetAll();

        $this->return["data"] = array_merge($this->return['data'], $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function GetCarReady(Request $r){
        $data = [];

        $return = (new Car)->GetCarReady();

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }
}