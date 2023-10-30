<?php

namespace AcmeWidgetCo\Store\Offers;


use AcmeWidgetCo\Store\Basket;
use AcmeWidgetCo\Store\Products\Product;

/**
 * A buy one get one special offer.
 * For example, "buy one red widget, get the second half price".
 */
class BuyOneGetOneDiscountedOffer extends Offer
{
    /**
     * The product being discounted.
     *
     * @var Product
     */
    private Product $product;

    /**
     * Amount to discount the product by.
     *
     * @var int
     */
    private int $discountPercent = 100;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): BuyOneGetOneDiscountedOffer
    {
        $this->product = $product;
        return $this;
    }

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): BuyOneGetOneDiscountedOffer
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    /**
     * @see Offer::applies()
     */
    public function applies(Basket $basket): bool
    {
        return $basket->getProductCount($this->product->getCode()) > 1;
    }

    /**
     * @see Offer::getDiscountCents()
     */
    public function getDiscountCents(Basket $basket): int
    {
        $count = floor($basket->getProductCount($this->product->getCode()) / 2);
        $discountPerProduct = $this->product->getPriceCents() * $this->discountPercent / 100;
        $discountCents = $discountPerProduct * $count;
        return round($discountCents);
    }
}