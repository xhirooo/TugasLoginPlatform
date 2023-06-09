<?php

namespace App\Controllers;

class Pesan extends BaseController
{
    public function index()
    {
        return view('inputpesan');
    }
    public function tampil()
    {
        return view('tampilpesan');
    }
}
