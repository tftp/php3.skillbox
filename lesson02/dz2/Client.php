<?php

class Client implements HasMoney
{
    private $product = null;
    protected int $money;

    public function __construct(int $money)
    {
        $this->money = $money;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function canBuyProduct(Product $product): bool
    {
        return $this->getMoney() >= $product->getPrice();
    }

    public function buyProduct(Product $product)
    {
        $this->product = $product;
        $this->money -= $product->getPrice();
    }

    public function getBoughtProduct()
    {
        return $this->product;
    }

}
