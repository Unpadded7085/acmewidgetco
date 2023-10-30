<?php

namespace AcmeWidgetCo\Store;

use InvalidArgumentException;
use AcmeWidgetCo\Store\Delivery\DeliveryCalculator;
use AcmeWidgetCo\Store\Offers\Offer;
use AcmeWidgetCo\Store\Offers\OfferRepository;
use AcmeWidgetCo\Store\Products\Product;
use AcmeWidgetCo\Store\Products\ProductRepository;

class Basket
{
    private ProductRepository $productRepository;
    private DeliveryCalculator $deliveryCalculator;
    private OfferRepository $offerRepository;

    /**
     * Contents of the basket.
     *
     * @var Product[]
     */
    private array $contents = [];

    /**
     * Index of the count by product in the basket, for fast lookups.
     * Key is the product code, the value is the count.
     *
     * @var int[]
     */
    private array $productCount = [];

    /**
     * Offers to apply.
     *
     * @var Offer[]
     */
    private array $offers = [];

    public function __construct(
        ProductRepository  $productRepository,
        DeliveryCalculator $deliveryCalculator,
        OfferRepository    $offerRepository
    ) {
        $this->productRepository = $productRepository;
        $this->deliveryCalculator = $deliveryCalculator;
        $this->offerRepository = $offerRepository;
    }

    /**
     * Add a {@link Product}.
     */
    public function addProduct(string $code): void
    {
        $product = $this->productRepository->findByCode($code);
        $this->contents[] = $product;
        if (!isset($this->productCount[$product->getCode()])) {
            $this->productCount[$product->getCode()] = 1;
        } else {
            $this->productCount[$product->getCode()]++;
        }
    }

    /**
     * Apply an {@link Offer}.
     *
     * @throws InvalidArgumentException if the offer does not apply.
     */
    public function addOffer(string $code): void
    {
        $offer = $this->offerRepository->findByCode($code);
        if (!$offer->applies($this)) {
            throw new InvalidArgumentException("Offer {$code} does not apply to basket");
        }
        $this->offers[$offer->getCode()] = $offer;
    }

    /**
     * @return int the count of a product by code, or 0 if not present.
     */
    public function getProductCount(string $code): int
    {
        return $this->productCount[$code] ?? 0;
    }

    /**
     * @return int the sum of the product cost in cents.
     */
    public function getProductTotalCents(): int
    {
        $cents = 0;
        foreach ($this->contents as $product) {
            $cents += $product->getPriceCents();
        }
        return $cents;
    }

    /**
     * @return int the cost for delivering the products.
     */
    public function getDeliveryCents(): int
    {
        return $this->deliveryCalculator->getDeliveryCostCents($this);
    }

    /**
     * @return int this total discount applied to the total.
     */
    public function getDiscountCents(): int
    {
        $cents = 0;
        foreach ($this->offers as $offer) {
            if (!$offer->applies($this)) {
                continue;
            }
            $cents += $offer->getDiscountCents($this);
        }
        return $cents;
    }

    /**
     * @return int subtotal for the basket.
     */
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
