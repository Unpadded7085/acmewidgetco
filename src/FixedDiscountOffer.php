<?php

namespace ThriveCart\Test;

/**
 * Discounts the basket's subtotal by a fixed percentage.
 * @deprecated Used for testing
 */
class FixedDiscountOffer extends Offer
{
    private int $discountPercent;

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): FixedDiscountOffer
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    public function applies(Basket $basket): bool
    {
        return true;
    }

    public function getDiscountCents(Basket $basket): int
    {
        $subtotal = $basket->getProductTotalCents();
        return ceil($subtotal / $this->getDiscountPercent());
    }
}