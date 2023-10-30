<?php

namespace ThriveCart\Test;

class ThresholdDeliveryCalculator implements DeliveryCalculator
{
    /**
     * @var int[]
     */
    private array $thresholds;

    private int $defaultCost = 0;

    public function getThresholds(): array
    {
        return $this->thresholds;
    }

    public function setThresholds(array $thresholds): ThresholdDeliveryCalculator
    {
        $this->thresholds = $thresholds;
        ksort($this->thresholds);
        return $this;
    }

    public function getDefaultCost(): int
    {
        return $this->defaultCost;
    }

    public function setDefaultCost(int $defaultCost): ThresholdDeliveryCalculator
    {
        $this->defaultCost = $defaultCost;
        return $this;
    }

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