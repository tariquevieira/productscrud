<?php


use Desafio\Produto\Modules\Category\Proxy\DeleteCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\FindCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\ListAllCategoriesControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\ListAllProductsControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\StoreCategoryControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\StoreProductControllerProxy;
use Desafio\Produto\Modules\Category\Proxy\UpdateCategoryControllerProxy;
use Desafio\Produto\Modules\Product\Proxy\DeleteProductControllerProxy;
use Desafio\Produto\Modules\Product\Proxy\FindProductControllerProxy;
use Desafio\Produto\Modules\Product\Proxy\UpdateProductControllerProxy;

return [
  '/category' =>         ListAllCategoriesControllerProxy::class,
  '/category/store' =>   StoreCategoryControllerProxy::class,
  '/category/find' =>    FindCategoryControllerProxy::class,
  '/category/delete' =>  DeleteCategoryControllerProxy::class,
  '/category/update' =>  UpdateCategoryControllerProxy::class,
  '/product' =>         ListAllProductsControllerProxy::class,
  '/product/store' =>   StoreProductControllerProxy::class,
  '/product/find' =>    FindProductControllerProxy::class,
  '/product/delete' =>  DeleteProductControllerProxy::class,
  '/product/update' =>  UpdateProductControllerProxy::class,
];
