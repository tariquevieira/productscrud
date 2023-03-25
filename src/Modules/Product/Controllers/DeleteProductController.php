<?php

namespace Desafio\Produto\Modules\Product\Controllers;

use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteProductController implements RequestHandlerInterface
{
  public function __construct(private ProductServiceInterface $service)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $body = $request->getParsedBody();
      $code = htmlspecialchars($body['code']);
      $this->service->deleteProduct($code);
      http_response_code(204);
      return new Response();
    } catch (NotFoundCategoryException  $e) {
      return new Response(body: $e->getMessage());
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
