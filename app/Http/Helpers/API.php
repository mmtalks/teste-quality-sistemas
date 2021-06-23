<?php

namespace App\Http\Helpers;

class API
{
    public static function res($success = 0, $message = "", $data = []){
        return ["success"=>$success, "message"=>$message, "data"=>$data];
    }
}