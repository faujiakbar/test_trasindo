<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $return = [
        "status" => 1,
        "message" => "Berhasil",
        "data" => [],
        "code" => 200
    ];

    public function __construct(){
        
    }
}
