<?php

namespace AcmeWidgetCo\Store\Delivery;


use AcmeWidgetCo\Store\Basket;

/**
 * Calculates shipping costs based on the subtotal in the {@link Basket}.
 * Provide an array of thresholds for shipping, and the lowest threshold will be used for the shipping cost.
 *
 * For example:
 * $thresholds = [
 *     5000 => 495
 *     9000 => 295
 * ]
 * Orders with a subtotal <$50 will cost $4.95, and <$90 will cost $2.95.
 *
 * When an order exceeds the maximum provided threshold, the {@code defaultCost} is used instead.
 */
class ThresholdDeliveryCalculator implements DeliveryCalculator
{
    /**
     * See class documentation ({@link ThresholdDeliveryCalculator}) for details.
     *
     * Key is the maximum order subtotal in cents, value is the shipping cost for the order.
     *
     * @var int[]
     */
    private array $thresholds;

    /**
     * @var int The cost of delivery when the order cost exceeds the maximum threshold amount.
     */
    private int $defaultCost = 0;

    public function setThresholds(array $thresholds): ThresholdDeliveryCalculator
    {
        $this->thresholds = $thresholds;
        ksort($this->thresholds);
        return $this;
    }

    public function setDefaultCost(int $defaultCost): ThresholdDeliveryCalculator
    {
        $this->defaultCost = $defaultCost;
        return $this;
    }

    /**
     * @see DeliveryCalculator::getDeliveryCostCents()
     */
    public function getDeliveryCostCents(Basket $basket): int
    {
        $subtotalCents = $basket->getSubtotalCents();
        // NOTE: This could be optimized by using binary search.
        foreach ($this->thresholds as $key => $value) {
            if ($subtotalCents < $key) {
                return $value;
            }
        }
        return $this->defaultCost;
    }
}