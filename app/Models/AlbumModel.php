<?php
namespace App\Models;

use CodeIgniter\Model;

class AlbumModel extends Model
{
    protected $table = 'albuns';
    protected $primaryKey = 'id_album';
    protected $allowedFields = [
        'id_artista',
        'nome'
    ];
}