<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// load library
use Illuminate\Http\Request;
use Illuminate\View\View;

// load Helpers
use App\Helpers\Mailer;

// load Models
use App\Models\Auth;

class AuthController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(Request $r){
        $data = [];

        return View('auth.auth',$data);
    }

    public function register(Request $r){
        $data = [];

        return View('auth.register',$data);
    }

    public function AuthRegister(Request $r){
        $data = [];

        $return = (new Auth)->AddUser($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }

    public function AuthIn(Request $r){
        $data = [];

        $return = (new Auth)->loginUser($r);

        $this->return = array_merge($this->return, $return);

        return response()->json($this->return,$this->return['code']);
    }
}