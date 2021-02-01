<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

    /**
     * Faz o retorno da resposta do servidor.
     * @access public
     * @param array $responseBody
     * @param int $code
     * @return string
     */
    public function baseResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
    {
        return $this->response->setStatusCode($code)->setJSON($responseBody)??'';
    }

    /**
     * Faz a solicitação dos parâmetros e do body.
     * @access public
     * @param IncomingRequest $request
     * @return array
     */
    public function baseRequest(IncomingRequest $request){
        return $request->getVar()??[];
    }

    /**
     * Faz a validação das regras.
     * @access public
     * @param array $input
     * @param array $rules
     * @param array $messages
     * @return string
     */
    public function baseValidateRequest(array $input, array $rules, array $messages = []){
        $this->validator = Services::Validation()->setRules($rules);
        if (is_string($rules)) {
            $validation = config('Validation');
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }
            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }
}
