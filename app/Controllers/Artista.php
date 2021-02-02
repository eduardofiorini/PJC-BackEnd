<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AlbumModel;
use App\Models\ArtistaModel;

class Artista extends ResourceController
{
    use ResponseTrait;

    private $artista_model;
    private $album_model;

    public function __construct() {
        $this->artista_model = new ArtistaModel();
        $this->album_model = new AlbumModel();
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
                $data = $this->artista_model->select('id_artista AS id, nome')->where('id_artista',$key)->first()??[];
                return $this->setResponseFormat($format)->respond($data);
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
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $this->artista_model->save(['nome' => $body["nome"]]);
                return $this->setResponseFormat($format)->respond(['msg' => 'Salvo com sucesso!']);
            /**
             * Return edit artista.
             */
            case 'edit':
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $this->artista_model->save(['id_artista' => $key, 'nome' => $body["nome"]]);
                return $this->setResponseFormat($format)->respond(['msg' => 'Editado com sucesso!']);
            /**
             * Return delete artista.
             */
            case 'delete':
                $this->artista_model->delete($key);
                $this->album_model->where('id_artista', $key)->delete();
                return $this->setResponseFormat($format)->respond(['msg' => 'Excluído com sucesso!']);
            /**
             * Return Default.
             */
            default:
                return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
        endswitch;
    }
}