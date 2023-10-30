<?php

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Store\Store;

class StoreIntegrationTest extends TestCase
{
    /**
     * @dataProvider ordersProvider
     */
    public function testExampleCases(array $products, int $cost, array $offers)
    {
        $store = Store::createDefault();
        $basket = $store->createBasket();
        foreach ($products as $code) {
            $basket->addProduct($code);
        }
        foreach ($offers as $offer) {
            $basket->addOffer($offer);
        }
        $this->assertEquals($cost, $basket->getTotalCents());
    }

    public static function ordersProvider(): array
    {
        return [
            [
                ["B01", "G01"],
                3785,
                []
            ],
            [
                ["R01", "R01"],
                5437,
                ["red-savings"]
            ],
            [
                ["R01", "G01"],
                6085,
                []
            ],
            [
                ["B01", "B01", "R01", "R01", "R01"],
                // Product total = 2 * 7.95 + 3 * 32.95 = 114.75
                // Discount = 32.95 / 2 = 16.475
                // Subtotal = 114.75 - 16.475 = 98.275
                // Shipping = 0
                9827,
                ["red-savings"]
            ],
        ];
    }
}