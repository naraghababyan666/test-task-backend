<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FunctionsController extends Controller
{
    public function makePassword( $length ) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);

    }

    public function makePin($length = 4){
        $FourDigitRandomNumber = mt_rand(1000,9999);
        echo $FourDigitRandomNumber;
    }
}
