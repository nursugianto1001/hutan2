<?php

namespace App\Http\Controllers\alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        return view('alumni.index');
    }
}
