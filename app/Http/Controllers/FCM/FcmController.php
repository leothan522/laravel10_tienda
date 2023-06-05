<?php

namespace App\Http\Controllers\FCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function index()
    {
        return view('dashboard.fcm.index');
    }
}
