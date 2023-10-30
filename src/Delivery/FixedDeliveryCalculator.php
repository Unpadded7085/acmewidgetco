<?php

namespace AcmeWidgetCo\Store\Delivery;


use AcmeWidgetCo\Store\Basket;

/**
 * Provides a fixed delivery cost for all orders.
 * Defaults to $5.
 *
 * @deprecated Replaced by {@link ThresholdDeliveryCalculator}.
 */
class FixedDeliveryCalculator implements DeliveryCalculator
{
    /**
     * @var int Cost of delivery.
     */
    private int $costCents = 500;

    public function setCostCents(int $costCents): FixedDeliveryCalculator
    {
        $this->costCents = $costCents;
        return $this;
    }

    /**
     * @see DeliveryCalculator::getDeliveryCostCents()
     */
    public function getDeliveryCostCents(Basket $basket): int
    {
        return $this->costCents;
    }
}