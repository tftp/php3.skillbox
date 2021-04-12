<?php

require 'HasMoney.php';
require 'Client.php';
require 'Shop.php';
require 'Product.php';

$shop = new Shop();

$shop->addProduct(new Product('1', 710));
$shop->addProduct(new Product('2', 100));
$shop->addProduct(new Product('3', 1000));
$shop->addProduct(new Product('4', 150));
$shop->addProduct(new Product('5', 500));

for ($i=1; $i < 6; $i++) {
    $client = new Client(rand(0, 1000));
    echo "Клиент $i встал в очередь, у него было денег " . $client->getMoney() . PHP_EOL;

    $shop->sellTheMostExpensiveProduct($client);

    if ($client->getBoughtProduct()) {
        echo "Клиент купил товар " . $client->getBoughtProduct()->getName();
        echo " на сумму " . $client->getBoughtProduct()->getPrice();
    } else {
        echo "Клиент ничего не купил";
    }
    echo ". У него осталось денег " . $client->getMoney() . PHP_EOL . PHP_EOL;
}

echo "Товаров куплено на сумму " . $shop->getMoney() . " руб." . PHP_EOL;
