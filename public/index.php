<?php

require(__DIR__ . '/../vendor/autoload.php');


if (!array_key_exists('PATH_INFO', $_SERVER)) $_SERVER['PATH_INFO'] = '/category';

$urlPath = $_SERVER['PATH_INFO'];

/** @var array */
$routes = require(__DIR__ . '/../routes/routes.php');

if (!array_key_exists($urlPath, $routes)) {
  http_response_code(404);
  echo '<h1>Not found!</h1>';
  exit();
}

require(__DIR__ . '/../config/bootstrap.php');

loadEnvironmentVariables(__DIR__ . '/../');

$container =  require(__DIR__ . '/../config/dependencies.php');

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
  $psr17Factory, // ServerRequestFactory
  $psr17Factory, // UriFactory
  $psr17Factory, // UploadedFileFactory
  $psr17Factory  // StreamFactory
);


$request = $creator->fromGlobals();

$classController = $routes[$urlPath];
$controller = $container->get($classController);

$response = $controller->handle($request);
$response->getHeaders();

foreach ($response->getHeaders() as $name => $values) {
  foreach ($values as $value) {
    header(sprintf('%s: %s', $name, $value), false);
  }
}

echo $response->getBody();
