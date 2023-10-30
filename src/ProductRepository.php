<?php

namespace ThriveCart\Test;


use InvalidArgumentException;

class ProductRepository
{
    /**
     * @var Product[]
     */
    private array $products = [];

    public function create(Product $product): Product
    {
        if (isset($this->products[$product->getCode()])) {
            throw new InvalidArgumentException("Product with code {$product->getCode()} already exists");
        }

        $now = new \DateTime();
        $product->setCreatedAt($now);
        $product->setUpdatedAt($now);
        $this->products[$product->getCode()] = $product;
        return $product;
    }

    public function findByCode(string $code): Product
    {
        if (!isset($this->products[$code])) {
            throw new InvalidArgumentException("Product with code {$code} not found");
        }

        return $this->products[$code];
    }
}