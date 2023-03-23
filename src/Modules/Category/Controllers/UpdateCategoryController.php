<?php

namespace Desafio\Produto\Modules\Category\Controllers;

use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UpdateCategoryController implements RequestHandlerInterface
{
  public function __construct(private CategoryInterfaceService $service)
  {
  }

  /**
   * Handle Request
   *
   * @param ServerRequestInterface $request
   * @return ResponseInterface
   */
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $code = $request->getQueryParams()['code'];
      $body = $request->getParsedBody();
      $name = htmlspecialchars($body['name']);
      $category = new Category(code: $code, name: $name);
      $this->service->updateCategory($category);
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
