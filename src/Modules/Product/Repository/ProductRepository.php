<?php

namespace Desafio\Produto\Modules\Product\Repository;

use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Category\Factory\CategoryFactory;
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

      if (empty($product)) {
        throw new NotFoundCategoryException(
          getenv('MSG_PRODUCT_NOTFOUND')
        );
      }

      return $product[0];
    } catch (NotFoundCategoryException $e) {
      throw new NotFoundCategoryException($e->getMessage());
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
  public function saveProduct(Product $product): Product
  {
    try {
      $insertQuery = 'INSERT INTO products (name,description,sku,price,category_code,amount)
         VALUES (:name,:description,:sku,:price,:category_code,:amount)';
      $statement = $this->connection->prepare($insertQuery);

      $success = $statement->execute([
        ':name' => $product->name(),
        ':description' => $product->description(),
        ':price' => $product->price(),
        ':sku' => $product->sku(),
        ':category_code' => $product->category()->code(),
        ':amount' => $product->amount(),
      ]);

      if ($success) {
        $product->setCode($this->connection->lastInsertId());
      }

      return $product;
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
          category_code = :category_code,
          amount = :amount
        where 
          code = :code';

      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $product->code());
      $statement->bindValue(':name', $product->name());
      $statement->bindValue(':description', $product->description());
      $statement->bindValue(':sku', $product->sku());
      $statement->bindValue(':price', $product->price());
      $category = $product->category();
      $statement->bindValue(':category_code', $category->code());
      $statement->bindValue(':amount', $product->amount());
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
        amount: (int)$productData['amount']
      );

      if (!empty($productData['category_code'])) {
        $categoryFactory = new CategoryFactory();
        $category = $categoryFactory->createByCode((int)$productData['category_code']);
        $product->setCategory($category);
      }

      $productList[] = $product;
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
