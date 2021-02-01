<?php
namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'auth';
    protected $primaryKey = 'id_auth';
    protected $allowedFields = [
        'nome',
        'email',
        'senha'
    ];
}