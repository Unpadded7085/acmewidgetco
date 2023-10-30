<?php

namespace ThriveCart\Test;

interface DeliveryCalculator
{
    public function getDeliveryCostCents(Basket $basket): int;
}