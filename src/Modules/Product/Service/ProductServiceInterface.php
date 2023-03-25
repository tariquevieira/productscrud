<?php

namespace Desafio\Produto\Modules\Product\Service;

use Desafio\Produto\Modules\Product\Model\Product;

interface ProductServiceInterface
{
  public function listAllProducts(): array;
  public function saveProduct(Product $product): Product;
  public function findProduct(int $code): Product;
  public function deleteProduct(int $code): void;
  public function updateProduct(Product $product): void;
}