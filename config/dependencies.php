<?php

use DataBase\Connection\ConnectionCreatorInterface;
use DataBase\Connection\ConnectionCreatorPdo;
use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Modules\Category\Service\CategoryService;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
  CategoryInterfaceService::class => new CategoryService(),
  ConnectionCreatorInterface::class => new ConnectionCreatorPdo()
]);

return $containerBuilder->build();
