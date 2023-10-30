<?php

namespace ThriveCart\Test;

class BuyOneNextDiscountOffer extends Offer
{
    private Product $product;
    private int $discountPercent;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): BuyOneNextDiscountOffer
    {
        $this->product = $product;
        return $this;
    }

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): BuyOneNextDiscountOffer
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    public function applies(Basket $basket): bool
    {
        return $basket->getProductCount($this->product->getCode()) > 1;
    }

    public function getDiscountCents(Basket $basket): int
    {
        if (!$this->applies($basket)) {
            return 0;
        }
        $count = floor($basket->getProductCount($this->product->getCode()) / 2);
        $discountPerProduct = $this->product->getPriceCents() * $this->discountPercent / 100;
        $discountCents = $discountPerProduct * $count;
        return round($discountCents);
    }
}