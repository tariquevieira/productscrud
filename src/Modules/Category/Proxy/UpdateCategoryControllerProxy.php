<?php

namespace Desafio\Produto\Modules\Category\Proxy;

use Desafio\Produto\Commons\Proxy\Controller\ControllerProxy;
use Desafio\Produto\Exceptions\InvalidMethodException;
use Desafio\Produto\Modules\Category\Controllers\UpdateCategoryController;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateCategoryControllerProxy extends ControllerProxy
{
  public function __construct()
  {
    parent::__construct();
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    try {
      if (!$this->verifyMethod(
        $request->getServerParams()["REQUEST_METHOD"],
        'post'
      )) {
        throw new InvalidMethodException('Invalid Http verb for this method.');
      }

      if (count($request->getParsedBody()) == 0) {
        throw new InvalidArgumentException('it is necessary to inform the name field');
      }

      if (!(int)$request->getQueryParams()['code']) {
        throw new InvalidArgumentException("The argument is invalid");
      }

      return $this->handleController(UpdateCategoryController::class, $request);
    } catch (InvalidMethodException | InvalidArgumentException $e) {
      return $this->returnError(400, $e->getMessage());
    } catch (\Exception $e) {
      return $this->returnError(500, $e->getMessage());
    }
  }
}
