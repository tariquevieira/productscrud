<?php

namespace Desafio\Produto\Modules\Category\Factory;

use DataBase\Connection\ConnectionCreatorPdo;
use Desafio\Produto\Modules\Category\Model\Category;
use Desafio\Produto\Modules\Category\Repository\CategoryRepository;

class CategoryFactory
{
  /**
   * Undocumented function
   *
   * @param integer $code
   * @return Category
   */
  public function createByCode(int $code): Category
  {
    $connection =  (new ConnectionCreatorPdo())->createConnection();
    $repository = new CategoryRepository($connection);

    $result = $repository->findCategoryByCode($code);

    return new Category((int)$result['code'], $result['name']);
  }
}
