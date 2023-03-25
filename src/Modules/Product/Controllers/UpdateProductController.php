<?php

namespace Desafio\Produto\Modules\Product\Controllers;

use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Product\Model\Product;
use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UpdateProductController implements RequestHandlerInterface
{
  public function __construct(private ProductServiceInterface $service)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $code = $request->getQueryParams()['code'];
      $body = $request->getParsedBody();
      $name = htmlspecialchars($body['name']);
      $description = htmlspecialchars($body['description']);
      $sku = htmlspecialchars($body['sku']);
      $categoryCode = filter_var($body['category_code'], FILTER_SANITIZE_NUMBER_INT);
      $price = filter_var($body['price'], FILTER_SANITIZE_NUMBER_FLOAT);
      $amount = filter_var($body['amount'], FILTER_SANITIZE_NUMBER_INT);

      $product = new Product(
        code: (int) $code,
        name: $name,
        sku: $sku,
        description: $description,
        price: $price,
        amount: $amount,
      );

      $product->setCategory(new Category(name: null, code: $categoryCode));

      $this->service->updateProduct($product);

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
