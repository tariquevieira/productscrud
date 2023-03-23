<?php

namespace Desafio\Produto\Modules\Category\Controllers;

use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Modules\Category\Service\CategoryService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StoreCategoryController implements RequestHandlerInterface
{
  /**
   * Constructor Method
   *
   * @param CategoryInterfaceService $service
   */
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
      $body = $request->getParsedBody();
      $name = htmlspecialchars($body['name']);
      $category = new Category(name: $name, code: null);
      $newCategory = $this->service->saveCategory($category);
      http_response_code(201);
      return new Response(headers: ['Content-Type' => 'application/json'], body: json_encode($newCategory->toArray()));
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
