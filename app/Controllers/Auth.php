<?php
namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Auth extends BaseController
{
    /**
     * Recebe as credencial, valida e retorna o token de acesso.
     * @access public
     * @return string
     */
    public function index()
    {
        $rules = [
            'email' => 'required|valid_email',
            'senha' => 'required|validateAuthPassword[email, password]'
        ];
        $errors = [
            'email' => [
                'required'    => 'O campo e-mail é obrigatório.',
                'valid_email' => 'E-mail inválido.',
            ],
            'senha' => [
                'required'             => 'O campo senha é obrigatório.',
                'validateAuthPassword' => 'Senha inválida.'
            ]
        ];
        $input = $this->baseRequest($this->request);
        if (!$this->baseValidateRequest($input, $rules, $errors)) {
            return $this->baseResponse($this->validator->getErrors(),ResponseInterface::HTTP_BAD_REQUEST);
        }
        return $this->generateCredential($input['email']);
    }

    /**
     * Gera as novas credenciais validas.
     * @access private
     * @param string $email
     * @param int $responseCode
     * @return string
     */
    private function generateCredential(string $email, int $responseCode = ResponseInterface::HTTP_OK){
        try {
            helper('jwt');
            return $this->baseResponse([
                'access_token' => jwtSignature($email)
            ]);
        } catch (Exception $exception) {
            return $this->baseResponse(['error' => $exception->getMessage()], $responseCode);
        }
    }
}