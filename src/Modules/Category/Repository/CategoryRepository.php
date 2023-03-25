<?php

namespace Desafio\Produto\Modules\Category\Repository;

use Desafio\Produto\Modules\Category\Model\Category;
use PDO;
use PDOException;

class CategoryRepository
{
  /**
   *
   * @param PDO $connection
   */
  public function __construct(private PDO $connection)
  {
  }


  /**
   * transform data into array
   *
   * @param \PDOStatement $statement
   * @return array 
   */
  private function hydrateCategories(\PDOStatement $statement): array
  {
    $categoryDataList = $statement->fetchAll();
    $categoryList = [];

    foreach ($categoryDataList as $categoryData) {
      $categoryList[] = (new Category(
        code: $categoryData['code'],
        name: $categoryData['name']
      ))->toArray();
    }

    return $categoryList;
  }

  /**
   * List all categories
   *
   * @return array
   */
  public function allCategories(): array
  {
    try {
      $sqlQuery = 'SELECT * FROM categories;';
      $statement = $this->connection->query($sqlQuery);
      return $this->hydrateCategories($statement);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }

  /**
   *
   * @param integer $code
   * @return boolean
   */
  public function deleteCategory(int $code): bool
  {
    try {
      $sqlQuery = 'DELETE FROM categories where code = :code';
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
   * @return array
   */
  public function findCategoryByCode(int $code): array
  {
    try {
      $sqlQuery = 'SELECT * FROM categories where code = :code';
      $statement = $this->connection->prepare($sqlQuery);
      $statement->bindValue(':code', $code);
      $statement->execute();
      $category = $this->hydrateCategories($statement);
      return $category[0];
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), 302);
    }
  }

  /**
   * saveCategory
   *
   * @param Category $category
   * @return Category
   */
  public function saveCategory(Category $category): Category
  {
    try {

      $insertQuery = 'INSERT INTO categories (name) VALUES (:name);';
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

  public function updateCategory(Category $category): bool
  {
    try {
      $sqlQuery = 'UPDATE categories SET name=:name where code = :code';
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
