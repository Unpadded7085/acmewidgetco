<?php

namespace AcmeWidgetCo\Store\Offers;

use DateTime;
use AcmeWidgetCo\Store\Basket;

/**
 * Base class for offers, which apply discounts to a {@link Basket}.
 */
abstract class Offer
{
    /**
     * Offer code.
     */
    private string $code;
    /**
     * Created timestamp.
     */
    private DateTime $createdAt;
    /**
     * Updated timestamp.
     */
    private DateTime $updatedAt;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Offer
    {
        $this->code = $code;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Offer
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Offer
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Check that the offer is still valid before applying the discount.
     *
     * @return bool {@code true} if the offer applies to the current {@link Basket}, {@code false} otherwise.
     */
    public abstract function applies(Basket $basket): bool;

    /**
     * @return int the discount for the {@link Basket}, in cents.
     */
    public abstract function getDiscountCents(Basket $basket): int;
}