<?php

namespace Desafio\Produto\Modules\Category\Service;


use DataBase\Connection\ConnectionCreatorPdo;
use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Modules\Category\Repository\CategoryRepository;
use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Exception;
use PDO;

class CategoryService implements CategoryInterfaceService
{
  private PDO $connection;
  private CategoryRepository $repository;

  public function __construct()
  {
    $this->connection =  (new ConnectionCreatorPdo())->createConnection();
    $this->repository = new CategoryRepository($this->connection);
  }

  /**
   * Delete Category
   *
   * @param integer $code
   * @return void
   */
  public function deleteCategory(int $code): void
  {
    try {
      if (count($this->repository->findCategoryByCode($code)) == 0) {
        throw new NotFoundCategoryException();
      }
      $this->repository->deleteCategory($code);
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
   * @return Category
   */
  public function findCategory(int $code): Category
  {
    try {
      if (count($this->repository->findCategoryByCode($code)) == 0) {
        throw new NotFoundCategoryException();
      }
      $name = $this->repository->findNameCategory($code);
      $category = new Category(code: $code, name: $name);
      return $category;
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
  public function listAllCategories(): array
  {
    try {
      $categories = $this->repository->allCategories();
      return $categories;
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 200);
    }
  }

  public function updateCategory(Category $category): void
  {
    try {
      if (count($this->repository->findCategoryByCode($category->code())) == 0) {

        throw new NotFoundCategoryException();
      }
      $this->repository->updateCategory($category);
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
  public function saveCategory(Category $category): Category
  {
    try {
      $category = $this->repository->saveCategory($category);
      return $category;
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 201);
    }
  }
}
