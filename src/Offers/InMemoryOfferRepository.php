<?php

namespace AcmeWidgetCo\Store\Offers;

use InvalidArgumentException;

/**
 * Repository for storing {@link Offer}s, using an in-memory array.
 */
class InMemoryOfferRepository implements OfferRepository
{
    /**
     * @var Offer[]
     */
    private array $offers = [];

    /**
     * @see OfferRepository::create()
     */
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

    /**
     * @see OfferRepository::findByCode()
     */
    public function findByCode(string $code): Offer
    {
        if (!isset($this->offers[$code])) {
            throw new InvalidArgumentException("Offer {$code} not found");
        }

        return $this->offers[$code];
    }
}
