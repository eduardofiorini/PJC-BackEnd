<?php
namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class RateLimitFilter implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $throttler = Services::throttler();
            if($request->getIPAddress() != getenv('jwt.ipSeverAuth')){
                return Services::response()->setJSON(['error' => 'Não é permitido o acesso ao endpoint por domínios externos.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
            if ($throttler->check($request->getIPAddress(), 60, MINUTE) === false)
            {
                return Services::response()->setStatusCode(429);
            }
        } catch (Exception $e) {
            return Services::response()->setJSON(['error' => $e->getMessage()])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}