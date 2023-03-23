<?php

namespace Desafio\Produto\Modules\Category\Controllers;

use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FindCategoryController implements RequestHandlerInterface
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
      $code = $request->getQueryParams()['code'];
      $category = $this->service->findCategory($code);
      return new Response(headers: ['Content-Type' => 'application/json'], body: json_encode($category->toArray()));
    } catch (NotFoundCategoryException  $e) {
      return new Response(body: $e->getMessage());
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
