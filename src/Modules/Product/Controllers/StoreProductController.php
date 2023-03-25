<?php

namespace Desafio\Produto\Modules\Product\Controllers;

use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Modules\Product\Model\Product;
use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StoreProductController implements RequestHandlerInterface
{
  /**
   * Undocumented function
   *
   * @param ProductServiceInterface $service
   */
  public function __construct(private ProductServiceInterface $service)
  {
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      $body = $request->getParsedBody();
      $name = htmlspecialchars($body['name']);
      $description = htmlspecialchars($body['description']);
      $sku = htmlspecialchars($body['sku']);
      $categoryCode = filter_var($body['category_code'], FILTER_SANITIZE_NUMBER_INT);
      $price = filter_var($body['price'], FILTER_SANITIZE_NUMBER_FLOAT);
      $amount = filter_var($body['amount'], FILTER_SANITIZE_NUMBER_INT);

      $product = new Product(
        code: null,
        name: $name,
        sku: $sku,
        description: $description,
        price: $price,
        amount: $amount,
      );

      $product->setCategory(new Category(name: null, code: $categoryCode));

      $newCategory = $this->service->saveProduct($product);
      http_response_code(201);
      return new Response(headers: ['Content-Type' => 'application/json'], body: json_encode($newCategory->toArray()));
    } catch (\Exception $e) {
      http_response_code(500);
      return new Response(body: $e->getMessage());
    }
  }
}
