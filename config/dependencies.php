<?php

use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Desafio\Produto\Modules\Category\Service\CategoryService;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
  CategoryInterfaceService::class => new CategoryService(),
]);

return $containerBuilder->build();