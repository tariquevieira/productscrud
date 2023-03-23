<?php

namespace Desafio\Produto\Modules\Category\Service;

use Desafio\Produto\Modules\Category\Model\Category;

interface CategoryInterfaceService
{
  public function listAllCategories(): array;
  public function saveCategory(Category $category): Category;
  public function findCategory(int $code): Category;
  public function deleteCategory(int $code): void;
  public function updateCategory(Category $category): void;
}