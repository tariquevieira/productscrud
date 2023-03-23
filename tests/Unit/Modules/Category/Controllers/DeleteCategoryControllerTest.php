<?php

namespace Tests\Unit\Modules\Category\Controllers;

use Desafio\Produto\Exceptions\NotFoundCategoryException;
use Desafio\Produto\Modules\Category\Controllers\DeleteCategoryController;
use Desafio\Produto\Modules\Category\Service\CategoryInterfaceService;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCategoryControllerTest extends TestCase
{
  /**
   * @var CategoryInterfaceService
   */
  private CategoryInterfaceService $serviceMock;

  /**
   * @var ResponseInterface
   */
  private ResponseInterface $responseMock;

  /**
   * @var ServerRequestInterface
   */
  private ServerRequestInterface $requestMock;

  /**
   * @var DeleteCategoryController
   */
  private DeleteCategoryController $testClass;

  /**
   * @var NotFoundCategoryException
   */
  private NotFoundCategoryException $notFoundCategoryException;

  /**
   * @var Exception
   */
  private Exception $exceptionMock;

  /**
   * SetUp Method
   *
   * @return void
   */
  public function setUp(): void
  {
    $this->serviceMock = $this->createMock(CategoryInterfaceService::class);
    $this->responseMock = $this->createMock(ResponseInterface::class);
    $this->requestMock = $this->createMock(ServerRequestInterface::class);
    $this->notFoundCategoryException = $this->createMock(NotFoundCategoryException::class);
    $this->exceptionMock = $this->createMock(Exception::class);

    $this->testClass = new DeleteCategoryController($this->serviceMock);
  }

  /**
   * Undocumented function
   *
   * @return void
   * @dataProvider provider
   */
  public function testSuccessInDeletingCategory(array $body): void
  {
    $this->requestMock->expects($this->once())
      ->method('getParsedBody')
      ->willReturn($body);

    $result = $this->testClass->handle($this->requestMock);
    $this->assertInstanceOf(ResponseInterface::class, $result);
    $this->assertEquals(204, $result->getStatusCode());
  }

  /**
   * Test not found category
   *
   * @param array $body
   * @return void
   * @dataProvider provider
   */
  public function testWhenCategoryNotFound(array $body): void
  {
    $this->requestMock->expects($this->once())
      ->method('getParsedBody')
      ->willReturn($body);

    $this->serviceMock
      ->expects($this->once())
      ->method('deleteCategory')
      ->with($body['code'])
      ->willThrowException($this->notFoundCategoryException);

    $result = $this->testClass->handle($this->requestMock);

    $this->assertInstanceOf(ResponseInterface::class, $result);
    $this->assertEquals(200, $result->getStatusCode());
  }


  /**
   * Test when any exception is thrown
   *
   * @param array $body
   * @return void
   * @dataProvider provider
   */
  public function testWhenAnyExceptionIsThrown(array $body): void
  {
    $this->requestMock->expects($this->once())
      ->method('getParsedBody')
      ->willReturn($body);

    $this->serviceMock
      ->expects($this->once())
      ->method('deleteCategory')
      ->with($body['code'])
      ->willThrowException($this->exceptionMock);

    $result = $this->testClass->handle($this->requestMock);

    $this->assertInstanceOf(ResponseInterface::class, $result);
    $this->assertEquals(500, $result->getStatusCode());
  }

  /**
   * Data Provider Mehtod
   *
   * @return array
   */
  public static function provider(): array
  {
    $code = '1230597';
    $body = ['code' => $code];
    return [
      [
        '$body' => $body
      ]
    ];
  }
}
