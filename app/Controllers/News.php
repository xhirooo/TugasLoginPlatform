<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    public function view($slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    public function create()
    {
        helper('form');

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // The form is not submitted, so returns the form. mengecek masukan dari user harus di isi terlebih dahulu
            return view('templates/header', ['title' => 'Create a news item'])
                . view('news/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']); //mengambil parameter dari create

        // Checks whether the submitted data passed the validation rules. melakukan validasi data atau mengecek data
        if (!$this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form. jika validasi data gagal akan kembali ke halaman create
            return view('templates/header', ['title' => 'Create a news item'])
                . view('news/create')
                . view('templates/footer');
        }

        $model = model(NewsModel::class); //memanggil model

        $model->save([ //mengambil data dan disimpan menggunakan save
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer'); // menampilkan halaman success
    }

    // public function update()
    // {
    //     helper('form');

    //     // Checks whether the form is submitted.
    //     if (!$this->request->is('post')) {
    //         // The form is not submitted, so returns the form. mengecek masukan dari user harus di isi terlebih dahulu
    //         return view('templates/header', ['title' => 'Create a news item'])
    //             . view('news/update')
    //             . view('templates/footer');
    //     }

    //     $post = $this->request->getPost(['title', 'body']);//mengambil parameter dari create

    //     // Checks whether the submitted data passed the validation rules. melakukan validasi data atau mengecek data
    //     // if (!$this->validateData($post, [
    //     //     'title' => 'required|max_length[255]|min_length[3]',
    //     //     'body'  => 'required|max_length[5000]|min_length[10]',
    //     // ])) {
    //     //     // The validation fails, so returns the form. jika validasi data gagal akan kembali ke halaman create
    //     //     return view('templates/header', ['title' => 'Create a news item'])
    //     //         . view('news/create')
    //     //         . view('templates/footer');
    //     // }

    //     $model = model(NewsModel::class); //memanggil model

    //     $id = 'id';
    //     $data = [
    //         'body' => $post['body'],
    //     ];

    //     $model->update($id,$data);

    //     return view('templates/header', ['title' => 'Create a news item'])
    //         . view('news/success')
    //         . view('templates/footer');
    // }
}
