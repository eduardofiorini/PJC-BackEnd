<?php
use App\Models\AuthModel;
use Firebase\JWT\JWT;

/**
 * Recebe o cabeçalho de autenticação JWT e retorna uma string.
 * @access public
 * @param string $authHeader
 * @return string
 */
if(!function_exists('jwtRequest')) {
    function jwtRequest(string $authHeader){
        if (is_null($authHeader)) {
            throw new Exception('Token jwt ausente ou inválido.');
        }
        return explode(' ', $authHeader)[1];
    }
}

/**
 * Faz a validação do token descriptografando e verificando na base de dados.
 * @access public
 * @param string $token
 * @return array
 */
if(!function_exists('jwtValidateRequest')) {
    function jwtValidateRequest(string $token)
    {
        $key = getenv('jwt.privateKey');
        $decode = JWT::decode($token, $key, ['HS256']);
        $authModel = new AuthModel();
        return $authModel->where('email', $decode->email)->first();
    }
}

/**
 * Faz a assinatura de um novo do token.
 * @access public
 * @param string $email
 * @return string
 */
if(!function_exists('jwtSignature')) {
    function jwtSignature(string $email)
    {
        $key = getenv('jwt.privateKey');
        $time = time();
        $expiration = $time + getenv('jwt.lifetime');
        $payload = [
            'email' => $email,
            'iat' => $time,
            'exp' => $expiration,
        ];
        return JWT::encode($payload, $key);
    }
}