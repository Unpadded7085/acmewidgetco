<?php

namespace AcmeWidgetCo\Store\Products;

use InvalidArgumentException;

/**
 * Repository for storing {@link Product}s, using an in-memory array.
 */
class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var Product[]
     */
    private array $products = [];

    public function create(Product $product): Product
    {
        if (isset($this->products[$product->getCode()])) {
            throw new InvalidArgumentException("Product {$product->getCode()} already exists");
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
            throw new InvalidArgumentException("Product {$code} not found");
        }

        return $this->products[$code];
    }
}
