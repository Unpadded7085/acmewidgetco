<?php

namespace AcmeWidgetCo\Store\Offers;

use AcmeWidgetCo\Store\Basket;

/**
 * Discounts the basket's subtotal by a fixed percentage.
 * For example, "save 20% on your cart".
 *
 * @deprecated Used for testing
 */
class FixedDiscountOffer extends Offer
{
    /**
     * @var int Amount to discount by in the range of 0 to 100.
     */
    private int $discountPercent = 0;

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): FixedDiscountOffer
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    /**
     * @see Offer::applies()
     */
    public function applies(Basket $basket): bool
    {
        return true;
    }

    /**
     * @see Offer::getDiscountCents()
     */
    public function getDiscountCents(Basket $basket): int
    {
        $productCostCents = $basket->getProductTotalCents();
        return ceil($productCostCents / $this->getDiscountPercent());
    }
}