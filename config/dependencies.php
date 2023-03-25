<?php

use DataBase\Connection\ConnectionCreatorInterface;
use DataBase\Connection\ConnectionCreatorPdo;
use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Modules\Category\Service\CategoryService;
use Desafio\Produto\Modules\Product\Service\ProductService;
use Desafio\Produto\Modules\Product\Service\ProductServiceInterface;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
  CategoryInterfaceService::class => new CategoryService(),
  ConnectionCreatorInterface::class => new ConnectionCreatorPdo(),
  ProductServiceInterface::class => new ProductService()
]);

return $containerBuilder->build();
