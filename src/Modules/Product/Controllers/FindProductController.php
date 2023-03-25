<?php

namespace Desafio\Produto\Modules\Product\Controllers;

use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FindProductController implements RequestHandlerInterface
{
  public function __construct(private ProductServiceInterface $service)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $code = (int)$request->getQueryParams()['code'];

      $product = $this->service->findProduct($code);

      return new Response(headers: ['Content-Type' => 'application/json'], body: json_encode($product->toArray()));
    } catch (NotFoundCategoryException  $e) {
      return new Response(body: $e->getMessage());
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
