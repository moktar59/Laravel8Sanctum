<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'It is a secure test route'
        ]);
    }
}
