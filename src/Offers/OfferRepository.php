<?php

namespace AcmeWidgetCo\Store\Offers;

/**
 * Repository for storing {@link Offer}s.
 */
interface OfferRepository
{
    /**
     * Create/store a new {@link Offer}.
     */
    public function create(Offer $offer): Offer;

    /**
     * Find an {@link Offer} by its code.
     */
    public function findByCode(string $code): Offer;
}
