<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setBody('Working fine!');
    }
}
