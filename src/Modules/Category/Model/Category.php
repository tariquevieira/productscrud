<?php

namespace Desafio\Produto\Modules\Category\Model;

class Category
{
  public function __construct(
    private ?int $code,
    private string $name
  ) {
  }

  /**
   * Get the value of code
   * @return int
   */
  public function code(): int
  {
    return $this->code;
  }

  /**
   * Set the value of code
   * @param int $code
   * @return  self
   */
  public function setCode(int $code): self
  {
    $this->code = $code;
    return $this;
  }

  /**
   * Get the value of name
   * @return string
   */
  public function name(): string
  {
    return $this->name;
  }

  /**
   * Turn class in array
   *
   * @return array
   */
  public function toArray(): array
  {
    return [
      'code' => $this->code,
      'name' => $this->name
    ];
  }
}
