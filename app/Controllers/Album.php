<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AlbumModel;
use App\Models\ArtistaModel;
use App\Models\ImagemModel;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class Album extends ResourceController
{
    use ResponseTrait;

    private $artista_model;
    private $album_model;
    private $imagem_model;
    private $aws_s3;

    public function __construct() {
        $this->artista_model = new ArtistaModel();
        $this->album_model = new AlbumModel();
        $this->imagem_model = new ImagemModel();
        $this->aws_s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => getenv('aws.endpoint'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => getenv('aws.key'),
                'secret' => getenv('aws.secret'),
            ],
        ]);
    }

    public function index($format = 'json'){
        return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
    }

    public function show($method = null, $key = null, $format = 'json'){
        switch ($method):
            /**
             * Return todos os albuns.
             */
            case 'all':
                $order = !empty($key) && strtolower($key) == 'desc' ? 'DESC' : 'ASC';
                $data = [
                    'albuns' => $this->album_model->select('albuns.id_album AS id, albuns.nome AS album, artistas.nome AS artista, imagens.nome AS imagem')
                                                  ->join('artistas', 'artistas.id_artista = albuns.id_artista')
                                                  ->join('imagens', 'imagens.id_album = albuns.id_album','left')
                                                  ->orderBy('albuns.nome',$order)->paginate(5)??[],
                    'page' => [
                        'atual' => $this->album_model->pager->getCurrentPage(),
                        'total' => $this->album_model->pager->getPageCount()
                    ]
                ];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return todos os albuns agrupados por artista.
             */
            case 'group':
                $order = !empty($key) && strtolower($key) == 'desc' ? 'DESC' : 'ASC';
                $albuns = $this->album_model->select('albuns.id_album AS id, albuns.id_artista, albuns.nome AS album, imagens.nome AS imagem')
                    ->join('imagens', 'imagens.id_album = albuns.id_album','left')
                    ->findAll();
                $artistas = $this->artista_model->select('id_artista AS id, nome AS artista')
                                                ->orderBy('nome',$order)->paginate(2)??[];
                foreach ($artistas as $key=>$item){
                    $artistas[$key]['albuns'] = [];
                    foreach ($albuns as $subitem){
                       if($subitem['id_artista'] == $item['id']){
                           unset($subitem['id_artista']);
                           array_push($artistas[$key]['albuns'],$subitem);
                       }
                    }
                }
                $data = [
                    'artistas' => $artistas,
                    'page' => [
                        'atual' => $this->artista_model->pager->getCurrentPage(),
                        'total' => $this->artista_model->pager->getPageCount()
                    ]
                ];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return os album pelo ID.
             */
            case 'id':
                $data = $this->album_model->select('id_album AS id, albuns.nome AS album, artistas.nome AS artista')
                                          ->join('artistas', 'artistas.id_artista = albuns.id_artista')
                                          ->where('id_album',$key)->first()??[];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return buscar os albuns por nome.
             */
            case 'search':
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $order = !empty($key) && strtolower($key) == 'desc' ? 'DESC' : 'ASC';
                $data = $this->album_model->select('id_album AS id, albuns.nome AS album, artistas.nome AS artista,')
                                          ->join('artistas', 'artistas.id_artista = albuns.id_artista')
                                          ->like('albuns.nome',$body["nome"])
                                          ->orderBy('albuns.nome',$order)
                                          ->findAll()??[];
                return $this->setResponseFormat($format)->respond($data);
            /**
             * Return add album.
             */
            case 'add':
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["id_artista"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro id_artista é nulo.']);
                }
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $this->album_model->save(['id_artista' => $body["id_artista"], 'nome' => $body["nome"]]);
                return $this->setResponseFormat($format)->respond(['msg' => 'Salvo com sucesso!']);
            /**
             * Return edit album.
             */
            case 'edit':
                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["nome"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro nome é nulo.']);
                }
                $this->album_model->save(['id_album' => $key, 'nome' => $body["nome"]]);
                return $this->setResponseFormat($format)->respond(['msg' => 'Editado com sucesso!']);
            /**
             * Return delete album.
             */
            case 'delete':
                $this->album_model->delete($key);
                return $this->setResponseFormat($format)->respond(['msg' => 'Excluído com sucesso!']);
            /**
             * Return upload image album.
             */
            case 'upload':
                helper('file');
                $file = $this->request->getFile('file');
                if(!$file){
                    return $this->setResponseFormat($format)->respond(['error' => 'O arquivo não foi encontrado!']);
                }

                $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                if(empty($body["id_album"]??"")){
                    return $this->setResponseFormat($format)->respond(['error' => 'O parâmetro id_album é nulo.']);
                }

                try {
                    $insert = $this->aws_s3->putObject([
                        'Bucket' => 'pjc-mt-emf',
                        'Key'    => $file->getName(),
                        'SourceFile'   => $file->getTempName(),
                        'ContentType' => mime_content_type($file->getTempName())
                    ]);
                    $this->imagem_model->save(['id_album'=>$body["id_album"],'nome'=>$file->getName()]);
                }catch (AwsException $e) {
                    return $this->setResponseFormat($format)->respond(['error' => $e->getMessage()]);
                }

                if($insert['@metadata']['statusCode'] == 200){
                    return $this->setResponseFormat($format)->respond(['msg' => 'Enviado com sucesso!']);
                }else{
                    return $this->setResponseFormat($format)->respond(['error' => 'Ocorreu uma falha!']);
                }

            /**
             * Return busca a imagem do album.
             */
            case 'image':
                try {
                    $retrive = $this->aws_s3->getObject([
                        'Bucket' => 'pjc-mt-emf',
                        'Key'    => $key
                    ]);
                }catch (AwsException $e) {
                    return $this->setResponseFormat($format)->respond(['imagem' => '','error' => $e->getMessage()]);
                }
                return $this->setResponseFormat($format)->respond(['imagem' => 'data:image/png' . ';base64,' . base64_encode($retrive['Body'])]);

            /**
             * Return Default.
             */
            default:
                return $this->setResponseFormat($format)->respond(['error' => 'Chamada ao método é inválida.']);
        endswitch;
    }
}