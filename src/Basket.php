<?php

namespace ThriveCart\Test;

use InvalidArgumentException;

class Basket
{
    private ProductRepository $productRepository;
    private DeliveryCalculator $deliveryCalculator;
    private OfferRepository $offerRepository;

    /**
     * @var Product[]
     */
    private array $products = [];

    /**
     * @var int[]
     */
    private array $productCount = [];

    /**
     * @var Offer[]
     */
    private array $offers = [];

    public function __construct(ProductRepository  $productRepository,
                                DeliveryCalculator $deliveryCalculator,
                                OfferRepository    $offerRepository)
    {
        $this->productRepository = $productRepository;
        $this->deliveryCalculator = $deliveryCalculator;
        $this->offerRepository = $offerRepository;
    }

    public function addProduct(string $code): void
    {
        $product = $this->productRepository->findByCode($code);
        $this->products[] = $product;
        if (!isset($this->productCount[$product->getCode()])) {
            $this->productCount[$product->getCode()] = 1;
        } else {
            $this->productCount[$product->getCode()]++;
        }
    }

    public function addOffer(string $code): void
    {
        $offer = $this->offerRepository->findByCode($code);
        if (!$offer->applies($this)) {
            throw new InvalidArgumentException("Offer {$code} does not apply to basket");
        }
        $this->offers[$offer->getCode()] = $offer;
    }

    public function getProductCount(string $code): int
    {
        return $this->productCount[$code] ?? 0;
    }

    public function getProductTotalCents(): int
    {
        $cents = 0;
        foreach ($this->products as $product) {
            $cents += $product->getPriceCents();
        }
        return $cents;
    }

    public function getDeliveryCents(): int
    {
        return $this->deliveryCalculator->getDeliveryCostCents($this);
    }

    public function getDiscountCents(): int
    {
        $cents = 0;
        foreach ($this->offers as $offer) {
            $cents += $offer->getDiscountCents($this);
        }
        return $cents;
    }

    public function getSubtotalCents(): int
    {
        return $this->getProductTotalCents() - $this->getDiscountCents();
    }

    /**
     * @return int the total cost of the basket.
     */
    public function getTotalCents(): int
    {
        $productTotalCents = $this->getProductTotalCents();
        $discountCents = $this->getDiscountCents();
        $deliveryCents = $this->getDeliveryCents();
        $totalCents = $productTotalCents - $discountCents + $deliveryCents;
        return max(0, $totalCents);
    }
}