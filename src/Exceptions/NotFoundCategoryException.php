<?php

namespace Desafio\Produto\Exceptions;

class NotFoundCategoryException  extends \Exception
{
  /**
   * Constructor Method
   *
   * @param string $message
   */
  public function __construct(string $message = 'Category not found.')
  {
    parent::__construct($message);
  }
}
