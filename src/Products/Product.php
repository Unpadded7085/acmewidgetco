<?php

namespace AcmeWidgetCo\Store\Products;

use DateTime;

/**
 * A product to be sold.
 */
class Product
{
    /**
     * Name of the product.
     */
    private string $name;
    /**
     * Code representing the product. E.g., "Red Widget".
     */
    private string $code;
    /**
     * Price of the product in cents.
     */
    private int $priceCents;
    /**
     * Created timestamp.
     */
    private DateTime $createdAt;
    /**
     * Updated timestamp.
     */
    private DateTime $updatedAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Product
    {
        $this->code = $code;
        return $this;
    }

    public function getPriceCents(): int
    {
        return $this->priceCents;
    }

    public function setPriceCents(int $priceCents): Product
    {
        $this->priceCents = $priceCents;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Product
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}