<?php

namespace App\Controllers;

class Todolist extends BaseController
{
    protected $todolistModel;
    public function __construct(){
        $this->todolistModel = new \App\Models\TodolistModel();
    }
    public function index()
    {
        $todolist = $this->todolistModel -> findAll();
        $data = [
            'title' => 'Daftar Kegiatan',
            'todolist' => $todolist
        ];

        //dd($todolist);

        return view('todolist/index', $data);
    }

    public function save(){
        $this->todolistModel->save([
            'idkegiatan' => $this->request->getVar('idkegiatan'),
            'kegiatan' => $this->request->getVar('kegiatan'),
            'status' => $this->request->getVar('status')
        ]);
        return redirect()->to('/todolist');
    }
}
