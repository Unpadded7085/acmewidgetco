<?php

namespace ThriveCart\Test;

use DateTime;

abstract class Offer
{
    private string $code;
    private DateTime $createdAt;
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

    public abstract function applies(Basket $basket): bool;

    public abstract function getDiscountCents(Basket $basket): int;
}