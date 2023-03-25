<?php

namespace Desafio\Produto\Modules\Product\Controllers;

use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ListAllProductsController implements RequestHandlerInterface
{
  public function __construct(private ProductServiceInterface $service)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $products = $this->service->listAllProducts();
      return new Response(200, ['Content-Type' => 'application/json'], json_encode($products));
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage(), status: 500);
    }
  }
}
