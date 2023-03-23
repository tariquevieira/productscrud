<?php

namespace Desafio\Produto\Modules\Product\Model;

use Desafio\Produto\Modules\Category\Model\Category;


class Product
{
  /** @var Category[]  */
  private $categories = [];

  /**
   * Method Constructor
   *
   * @param integer|null $code
   * @param string $name
   * @param string $sku
   * @param string $description
   * @param float $price
   * @param integer $amount
   */
  public function __construct(
    private ?int $code,
    private string $name,
    private string $sku,
    private string $description,
    private float $price,
    private int $amount
  ) {
  }

  /**
   * Get the value of price
   *
   * @return  int
   */
  public function getAmount()
  {
    return $this->price;
  }

  /**
   * Get the value of code
   * 
   * @return int
   */
  public function code(): int
  {
    return $this->code;
  }

  /**
   * Set the value of code
   * 
   * @param int $code
   * @return  self
   */
  public function setCode(int $code): self
  {
    $this->code = $code;
    return $this;
  }

  /**
   * Get the value of description
   *
   * @return  string
   */
  public function getDescription()
  {
    return $this->description;
  }


  /**
   * Get the value of name
   * 
   * @return string
   */
  public function name(): string
  {
    return $this->name;
  }

  /**
   * Get the value of sku
   *
   * @return  string
   */
  public function getSku()
  {
    return $this->sku;
  }

  /**
   * Adding catgories in array
   *
   * @param integer $code
   * @param string $name
   * @return void
   */
  public function addCategories(int $code, string $name): void
  {
    $category = new Category($code, $name);
    $this->categories[] = $category;
  }


  /**
   * Get the value of price
   *
   * @return  float
   */
  public function getPrice()
  {
    return $this->price;
  }

  /**
   * Turn class into array
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
