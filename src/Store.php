<?php

namespace AcmeWidgetCo\Store;

use AcmeWidgetCo\Store\Delivery\DeliveryCalculator;
use AcmeWidgetCo\Store\Delivery\ThresholdDeliveryCalculator;
use AcmeWidgetCo\Store\Offers\BuyOneGetOneDiscountedOffer;
use AcmeWidgetCo\Store\Offers\InMemoryOfferRepository;
use AcmeWidgetCo\Store\Offers\OfferRepository;
use AcmeWidgetCo\Store\Products\InMemoryProductRepository;
use AcmeWidgetCo\Store\Products\Product;
use AcmeWidgetCo\Store\Products\ProductRepository;

class Store
{
    private ProductRepository $productRepository;
    private DeliveryCalculator $deliveryCalculator;
    private OfferRepository $offerRepository;

    public function __construct(ProductRepository|null  $productRepository,
                                DeliveryCalculator|null $deliveryCalculator,
                                OfferRepository|null    $offerRepository)
    {
        $this->productRepository = $productRepository ?? self::defaultProductRepository();
        $this->deliveryCalculator = $deliveryCalculator ?? self::defaultDeliveryCalculator();
        $this->offerRepository = $offerRepository ?? self::defaultOfferRepository($this->productRepository);
    }

    public static function createDefault(): Store
    {
        // TODO: Can these args be made optional?
        return new Store(null, null, null);
    }

    private static function defaultProductRepository(): ProductRepository
    {
        $productRepository = new InMemoryProductRepository();
        $productRepository->create((new Product())
            ->setName("Red Widget")
            ->setCode("R01")
            ->setPriceCents(3295));
        $productRepository->create((new Product())
            ->setName("Green Widget")
            ->setCode("G01")
            ->setPriceCents(2495));
        $productRepository->create((new Product())
            ->setName("Blue Widget")
            ->setCode("B01")
            ->setPriceCents(795));
        return $productRepository;
    }

    private static function defaultDeliveryCalculator(): DeliveryCalculator
    {
        return (new ThresholdDeliveryCalculator())
            ->setThresholds([
                5000 => 495,
                9000 => 295
            ])
            ->setDefaultCost(0);
    }

    private static function defaultOfferRepository(ProductRepository $productRepository): OfferRepository
    {
        $offerRepository = new InMemoryOfferRepository();

        $product = $productRepository->findByCode("R01");
        $offerRepository->create((new BuyOneGetOneDiscountedOffer())
            ->setCode("red-savings")
            ->setProduct($product)
            ->setDiscountPercent(50));

        return $offerRepository;
    }

    public function createBasket(): Basket
    {
        return new Basket(
            $this->productRepository,
            $this->deliveryCalculator,
            $this->offerRepository);
    }
}