<?php

namespace ThriveCart\Test;

class FixedDeliveryCalculator implements DeliveryCalculator
{
    public function getDeliveryCostCents(Basket $basket): int
    {
        return 500;
    }
}