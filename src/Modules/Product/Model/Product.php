<?php

namespace Desafio\Produto\Modules\Product\Model;

use Desafio\Produto\Modules\Category\Model\Category;


class Product
{
  /** @var Category*/
  private ?Category $category;

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
   * Get the value of name
   * 
   * @return string
   */
  public function name(): string
  {
    return $this->name;
  }

  /**
   * Undocumented function
   *
   * @param string $name
   * @return self
   */
  public function setName(string $name): self
  {
    $this->name = $name;
    return $this;
  }

  /**
   * Get the value of description
   *
   * @return  string
   */
  public function description()
  {
    return $this->description;
  }

  /**
   * Undocumented function
   *
   * @param string $description
   * @return self
   */
  public function setDescription(string $description): self
  {
    $this->description = $description;
    return $this;
  }

  /**
   * Get the value of sku
   *
   * @return  string
   */
  public function sku(): string
  {
    return $this->sku;
  }

  /**
   * Get the value of sku
   *
   * @return  string
   */
  public function setSku(string $sku): self
  {
    $this->sku = $sku;
    return $this;
  }

  /**
   * Get Category
   *
   * @return Category
   */
  public function category(): Category
  {
    return $this->category;
  }

  /**
   * 
   *
   * @param Category $categories
   * @return self
   */
  public function setCategory(Category $category): self
  {
    $this->category = $category;
    return $this;
  }


  /**
   * Get the value of price
   *
   * @return  float
   */
  public function price(): float
  {
    return $this->price;
  }

  /**
   * Undocumented function
   *
   * @param float $price
   * @return self
   */
  public function setPrice(float $price): self
  {
    $this->price = $price;
    return $this;
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
      'name' => $this->name,
      'description' => $this->description,
      'sku' => $this->sku,
      'price' => $this->price,
      'category' => $this->category->toArray() ?? [],
    ];
  }
}
