<?php

namespace App\Validation;

use App\Models\AuthModel;
use Exception;

class AuthRules
{
    public function validateAuthPassword(string $str, string $fields, array $data): bool
    {
        try {
            $model = new AuthModel();
            $obj = $model->where('email',$data['email'])->first();
            return md5($data['senha']) == $obj['senha'];
        } catch (Exception $e) {
            return false;
        }
    }
}