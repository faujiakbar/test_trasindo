<?php
namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;

// load library
use Illuminate\Http\Request;
use Illuminate\View\View;

// load Helpers
use App\Helpers\Mailer;

// load Models
use App\Models\Rent;

class RentController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function AddRent(Request $r){
        $data = [];

        $return = (new Rent)->AddRent($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function GetAllRent(Request $r){
        $data = [];

        $return = (new Rent)->GetAll();

        $this->return["data"] = array_merge($this->return['data'], $return);

        return response()->json($this->return,$this->return['code']);
    }
}