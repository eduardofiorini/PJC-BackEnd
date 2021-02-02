<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtistaModel;

class Artista extends ResourceController
{
    use ResponseTrait;

    private $artista_model;

    public function __construct() {
        $this->artista_model = new ArtistaModel();
    }

    public function index($format = 'json'){
        return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
    }

    public function show($method = null, $key = null, $format = 'json'){
        switch ($method):
            /**
             * Return todos os artistas.
             */
            case 'all':
                $order = !empty($key) && strtolower($key) == 'desc' ? 'DESC' : 'ASC';
                $data = $this->artista_model->select('id_artista AS id, nome')->orderBy('nome',$order)->findAll()??[];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return os artista pelo ID.
             */
            case 'id':
                break;
            /**
             * Return buscar os artistas por nome.
             */
            case 'search':
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $order = !empty($key) && strtolower($key) == 'desc' ? 'DESC' : 'ASC';
                $data = $this->artista_model->select('id_artista AS id, nome')->like('nome',$body["nome"])->orderBy('nome',$order)->findAll()??[];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return add artista.
             */
            case 'add':
                break;
            /**
             * Return edit artista.
             */
            case 'edit':
                break;
            /**
             * Return delete artista.
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