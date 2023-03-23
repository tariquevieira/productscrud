<?php

namespace Desafio\Produto\Modules\Category\Controllers;

use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Modules\Category\Service\CategoryService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ListAllCategoriesController implements RequestHandlerInterface
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
      $categories = $this->service->listAllCategories();
      return new Response(200, ['Content-Type' => 'application/json'], json_encode($categories));
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
