<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Ini Method untuk memanggil halaman about
    public function index()
    {
        return view('about');
    }
}
