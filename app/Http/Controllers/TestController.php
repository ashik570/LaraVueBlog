<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
    	return view('welcome');
    }
    public function test(){
        return response()->json([
            'msg' => 'some error occurred'
        ],422);
    }
}
