<?php

namespace AcmeWidgetCo\Store\Delivery;

use AcmeWidgetCo\Store\Basket;

/**
 * Calculates the cost of delivering the items in a {@link Basket}.
 */
interface DeliveryCalculator
{
    /**
     * @return int the cost (in cents) to deliver the items in the {@link Basket}.
     */
    public function getDeliveryCostCents(Basket $basket): int;
}