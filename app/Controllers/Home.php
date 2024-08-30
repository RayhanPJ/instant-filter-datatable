<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function dummyData()
    {
        $filePath = FCPATH . 'data.json';
        $jsonData = file_get_contents($filePath);

        return $this->response->setJSON(json_decode($jsonData, true));

    }
}
