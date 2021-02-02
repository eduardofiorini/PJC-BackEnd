<?php
namespace App\Models;

use CodeIgniter\Model;

class ImagemModel extends Model
{
    protected $table = 'imagens';
    protected $primaryKey = 'id_imagem';
    protected $allowedFields = [
        'id_album',
        'nome'
    ];
}