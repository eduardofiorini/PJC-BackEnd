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
             * Return todos os albuns.
             */
            case 'all':
                break;
            /**
             * Return os album pelo ID.
             */
            case 'id':
                break;
            /**
             * Return buscar os albuns por nome.
             */
            case 'search':
                break;
            /**
             * Return add album.
             */
            case 'add':
                break;
            /**
             * Return edit album.
             */
            case 'edit':
                break;
            /**
             * Return delete album.
             */
            case 'delete':
                break;
            /**
             * Return Default.
             */
            default:
                return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
        endswitch;
    }
}