<?php

class Shop implements HasMoney
{
    private array $products;
    private int $money = 0;

    public function getMoney(): int
    {
        return $this->money;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getProductsSortedByPrice(): array
    {
        $products = $this->products;

        usort($products, fn($productCurrent, $productNext) => $productNext->getPrice() <=> $productCurrent->getPrice());

        return $products;
    }

    public function sellTheMostExpensiveProduct(Client $client)
    {
        foreach ($this->getProductsSortedByPrice() as $product) {
            if ($client->canBuyProduct($product)) {
                $client->buyProduct($product);
                $this->sellProduct($product);

                return true;
            }
        }
        return false;
    }

    private function sellProduct(Product $product)
    {
        $this->money += $product->getPrice();

        $keyProduct = array_search($product, $this->products);
        unset($this->products[$keyProduct]);
    }

}
