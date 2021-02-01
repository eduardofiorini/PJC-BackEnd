<?php
namespace App\Models;

use CodeIgniter\Model;

class ArtistaModel extends Model
{
    protected $table = 'artistas';
    protected $primaryKey = 'id_artista';
    protected $allowedFields = [
        'nome'
    ];
}