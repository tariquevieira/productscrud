<?php

namespace Desafio\Produto\Modules\Product\Repository;

use Desafio\Produto\Modules\Product\Model\Product;
use PDO;
use PDOException;

class ProductRepository
{
  /**
   *
   * @param PDO $connection
   */
  public function __construct(private PDO $connection)
  {
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

      $productList[] = new Product(
        code: $productData['code'],
        name: $productData['name'],
        sku: $productData['sku'],
        description: $productData['description'],
        price: $productData['price'],
        amount: $productData['amount']
      );
    }

    return $productList;
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

  /**
   *
   * @param integer $code
   * @return boolean
   */
  public function deleteProductCategory(int $code): bool
  {
    try {
      $sqlQuery = 'DELETE FROM products_categories where code = :code';
      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $code);
      $success = $statement->execute();
      if (!$success) throw new \PDOException("Não foi possivel deletar o exame: $code.");
      return $success;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 303);
    }
  }

  /**
   * 
   *
   * @param integer $code
   * @return string
   */
  public function findNameProduct(int $code): string
  {
    try {
      $sqlQuery = 'SELECT name FROM products where code = :code';
      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $code);
      $statement->execute();
      $name = $statement->fetch();
      return $name['name'];
    } catch (\PDOException   $e) {
      throw new \PDOException($e->getMessage(), 302);
    }
  }

  /**
   *
   * @param integer $code
   * @return Product
   */
  public function findProductByCode(int $code): Product
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
  public function updateProduct(Product $category): bool
  {
    try {
      $sqlQuery = 'UPDATE products SET name=:name where code = :code';

      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $category->code());
      $statement->bindValue(':name', $category->name());
      $success = $statement->execute();

      if (!$success) throw new \PDOException("Não foi possivel deletar o exame:" . $category->code() . ".");

      return $success;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 304);
    }
  }
}
