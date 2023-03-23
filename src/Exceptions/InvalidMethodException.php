<?php

namespace Desafio\Produto\Exceptions;

class InvalidMethodException extends \Exception
{
  public function __construct(string $message)
  {
    parent::__construct($message);
  }
}