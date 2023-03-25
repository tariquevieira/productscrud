<?php

namespace Desafio\Produto\Modules\Product\Proxy;

use Desafio\Produto\Commons\Proxy\Controller\ControllerProxy;
use Desafio\Produto\Exceptions\InvalidMethodException;
use Desafio\Produto\Modules\Product\Controllers\ListAllProductsController;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListAllProductsControllerProxy extends ControllerProxy
{
  public function __construct()
  {
    parent::__construct();
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      if (!$this->verifyMethod(
        $request->getServerParams()["REQUEST_METHOD"],
        'get'
      )) {
        throw new InvalidMethodException('Invalid Http verb for this method.');
      }
      return $this->handleController(ListAllProductsController::class, $request);
    } catch (InvalidMethodException $e) {
      http_response_code(400);
      return new Response(headers: [], body: $e->getMessage());
    } catch (\Exception $e) {
      return $this->returnError(500, $e->getMessage());
    }
  }
}
