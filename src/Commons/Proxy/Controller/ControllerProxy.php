<?php

namespace Desafio\Produto\Commons\Proxy\Controller;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class ControllerProxy implements RequestHandlerInterface
{
  /**
   * Method Construtctor
   */
  public function __construct()
  {
  }

  /**
   *
   * @param string $controller
   * @param ServerRequestInterface $request
   * @return ResponseInterface
   */
  protected function handleController(string $controller, ServerRequestInterface $request): ResponseInterface
  {
    $container =  require(__DIR__ . '/../../../../config/dependencies.php');
    $controller = $container->get($controller);
    return $controller->handle($request);
  }

  /**
   * Retorn erro in json format.
   *
   * @param integer $status
   * @param string $message
   * @return ResponseInterface
   */
  protected function returnError(int $status, string $message): ResponseInterface
  {
    http_response_code($status);
    return new Response(
      headers: ['content-type' => 'application/json'],
      body: json_encode(['message' => $message])
    );
  }

  /**
   * checks if the request method is the same 
   * as the controller method
   *
   * @param ServerRequestInterface $request
   * @param string $methodController
   * @return boolean
   */
  protected function verifyMethod(string $methodRequest, string $methodController): bool
  {
    $methodController = strtoupper($methodController);
    if ($methodController === $methodRequest) {
      return true;
    };
    return false;
  }
}
