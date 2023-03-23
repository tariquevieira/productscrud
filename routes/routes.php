<?php


use Desafio\Produto\Modules\Category\Proxy\DeleteCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\FindCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\ListAllCategoriesControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\StoreCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\UpdateCategoryControllerProxy;


return [
  '/category' =>         ListAllCategoriesControllerProxy::class,
  '/category/store' =>   StoreCategoryControllerProxy::class,
  '/category/find' =>    FindCategoryControllerProxy::class,
  '/category/delete' =>  DeleteCategoryControllerProxy::class,
  '/category/update' =>  UpdateCategoryControllerProxy::class,
];