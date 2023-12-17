<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// load library
use Illuminate\Http\Request;
use Illuminate\View\View;

// load Helpers
use App\Helpers\Mailer;

// load Models
use App\Models\Auth;

class HomeController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(Request $r){
        $data = [];

        return View('home.index',$data);
    }
}