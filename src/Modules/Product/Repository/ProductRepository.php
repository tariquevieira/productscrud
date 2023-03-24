<?php

namespace Desafio\Produto\Modules\Product\Repository;

use Desafio\Produto\Modules\Category\Factory\CategoryFactory;
use Desafio\Produto\Modules\Category\Repository\CategoryRepository;
use Desafio\Produto\Modules\Product\Model\Product;
use PDO;
use PDOException;

class ProductRepository
{

  /**
   *
   * @param PDO $connection
   */
  public function __construct(
    private PDO $connection
  ) {
  }


  /**
   * List all products
   *
   * @return array
   */
  public function allProducts(): array
  {
    try {
      $sqlQuery = 'SELECT * FROM products;';
      $statement = $this->connection->query($sqlQuery);
      return $this->hydrateProducts($statement);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }

  /**
   *
   * @param integer $code
   * @return Product
   */
  public function findProduct(int $code): Product
  {
    try {
      $sqlQuery = 'SELECT * FROM products where code = :code';
      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $code);
      $statement->execute();
      $product = $this->hydrateProducts($statement);
      return $product[0];
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 302);
    }
  }

  /**
   * saveProduct
   *
   * @param Product $category
   * @return Product
   */
  public function saveProduct(Product $category): Product
  {
    try {

      $insertQuery = 'INSERT INTO products (name) VALUES (:name);';
      $statement = $this->connection->prepare($insertQuery);

      $success = $statement->execute([
        ':name' => $category->name()
      ]);

      if ($success) {
        $category->setCode($this->connection->lastInsertId());
      }

      return $category;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 301);
    }
  }

  /**
   * Undocumented function
   *
   * @param Product $category
   * @return boolean
   */
  public function updateProduct(Product $product): bool
  {
    try {
      $sqlQuery = 'UPDATE products 
        SET 
          name = :name,
          description = :description,
          sku = :sku,
          price = :price,
          category = :category
        where 
          code = :code';

      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $product->code());
      $statement->bindValue(':name', $product->name());
      $statement->bindValue(':description', $product->description());
      $statement->bindValue(':sku', $product->sku());
      $category = $product->category();
      $statement->bindValue(':category', $category->code() ?? null);
      $success = $statement->execute();

      if (!$success) throw new \PDOException("Não foi possivel deletar o exame:" . $category->code() . ".");

      return $success;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 304);
    }
  }

  /**
   * Transform data into array of products
   *
   * @param \PDOStatement $statement
   * @return array 
   */
  private function hydrateProducts(\PDOStatement $statement): array
  {
    $productDataList = $statement->fetchAll();
    $productList = [];

    foreach ($productDataList as $productData) {

      $product = new Product(
        code: $productData['code'],
        name: $productData['name'],
        sku: $productData['sku'],
        description: $productData['description'],
        price: $productData['price'],
        amount: $productData['amount']
      );

      if (!empty($productData['category'])) {
        $categoryFactory = new CategoryFactory();
        $category = $categoryFactory->createByCode($product->code());
        $product->setCategory($category);
      }

      $productList[] = $product->toArray();
    }

    return $productList;
  }

  /**
   *
   * @param integer $code
   * @return boolean
   */
  public function deleteProduct(int $code): bool
  {
    try {
      $sqlQuery = 'DELETE FROM products where code = :code';
      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $code);
      $success = $statement->execute();
      if (!$success) throw new \PDOException("Não foi possivel deletar o exame: $code.");
      return $success;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 303);
    }
  }
}
