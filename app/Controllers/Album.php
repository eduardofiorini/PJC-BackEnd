<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Album extends ResourceController
{
    use ResponseTrait;

    public function index($format = 'json'){
        return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
    }

    public function show($method = null, $key = null, $format = 'json'){
        switch ($method):
            /**
             * Return Default.
             */
            default:
                return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
        endswitch;
    }
}