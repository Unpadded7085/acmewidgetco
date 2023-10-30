<?php

namespace ThriveCart\Test;

use InvalidArgumentException;

class OfferRepository
{
    /**
     * @var Offer[]
     */
    private array $offers = [];

    public function create(Offer $offer): Offer
    {
        if (isset($this->products[$offer->getCode()])) {
            throw new InvalidArgumentException("Offer {$offer->getCode()} already exists");
        }

        $now = new \DateTime();
        $offer->setCreatedAt($now);
        $offer->setUpdatedAt($now);
        $this->offers[$offer->getCode()] = $offer;
        return $offer;

    }

    public function findByCode(string $code): Offer
    {
        if (!isset($this->offers[$code])) {
            throw new InvalidArgumentException("Offer {$code} not found");
        }

        return $this->offers[$code];
    }
}