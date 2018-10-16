<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asana;
use App\User;
use DB;

class MeetingsController extends Controller
{
    public static function index(){
        $data = [];

        return view("pages.meetings", $data);
    } // index


}