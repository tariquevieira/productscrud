<?php

namespace Desafio\Produto\Modules\Product\Service;


use DataBase\Connection\ConnectionCreatorPdo;
use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Product\Model\Product;
use Desafio\Produto\Modules\Product\Repository\ProductRepository;
use Exception;
use PDO;

class ProductService implements ProductServiceInterface
{
  private PDO $connection;
  private ProductRepository $repository;

  /**
   * Constructor Method
   */
  public function __construct()
  {
    $this->connection =  (new ConnectionCreatorPdo())->createConnection();
    $this->repository = new ProductRepository($this->connection);
  }

  /**
   * Delete Category
   *
   * @param integer $code
   * @return void
   */
  public function deleteProduct(int $code): void
  {
    try {
      if (empty($this->repository->findProduct($code))) {
        throw new NotFoundCategoryException();
      }
      $this->repository->deleteProduct($code);
      return;
    } catch (NotFoundCategoryException $e) {
      throw new NotFoundCategoryException($e->getMessage());
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 204);
    }
  }

  /**
   * Find Category
   *
   * @param integer $code
   * @return Product
   */
  public function findProduct(int $code): Product
  {
    try {
      if (empty($this->repository->findProduct($code))) {
        throw new NotFoundCategoryException();
      }
      $product = $this->repository->findProduct($code);
      return $product;
    } catch (NotFoundCategoryException $e) {
      throw new NotFoundCategoryException($e->getMessage());
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 202);
    }
  }

  /**
   * List all categories
   *
   * @return array
   */
  public function listAllProducts(): array
  {
    try {
      $categories = $this->repository->allProducts();
      return $categories;
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500);
    }
  }

  /**
   * Undocumented function
   *
   * @param Product $product
   * @return void
   */
  public function updateProduct(Product $product): void
  {
    try {
      if (empty($this->repository->findProduct($product->code()))) {

        throw new NotFoundCategoryException();
      }
      $this->repository->updateProduct($product);
      return;
    } catch (NotFoundCategoryException $e) {
      throw new NotFoundCategoryException($e->getMessage());
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 205);
    }
  }

  /**
   * Insert a category
   *
   * @param Category $category
   * @return Category
   */
  public function saveProduct(Product $product): Product
  {
    try {
      $category = $this->repository->saveProduct($product);
      return $category;
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 201);
    }
  }
}
