<?php

namespace App\Controllers;


class Login extends BaseController
{
    public function index()
    {
        return view('login/loginpages');
    }

    public function check()
    {
        $post = $this->request->getPost(['usr', 'pwd']);
        if ($post['usr'] == 'admin' && $post['pwd'] == '123') { // mengecek masukan dari user
            $session = session();
            $session->set('pengguna', $post['usr']); //menyimpan hasil dari usr ke variable pengguna
            return view('login/home');
        } else {
            return view('login/fail');
        }
    }

    public function home() //untuk mengecek 
    {
        $session = session();
        if ($session->has('pengguna')) {
            $item = $session->get('pengguna');
            if ($item == 'admin') { //mengecek apakah admin atau bukan
                return view('login/home');
            } else {
                return view('login/loginpages');
            }
        } else {
            return view('login/loginpages');
        }
    }

    public function logout() //remove attribut session pengguna
    {
        $session = session();
        // $session->destroy(); //destroy akan menghancurakn semua session
        $session->remove('pengguna'); //bisa menggunakan destroy. 
        return view('login/loginpages');
    }
}
