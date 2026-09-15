<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index(){
        return view('about', [
        'nama' => 'Kaori',
        'kelas' => 'TRPL',
        'universitas' => 'Universitas Gadjah Mada'
        ]);
    }
}