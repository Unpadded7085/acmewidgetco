<?php

namespace AcmeWidgetCo\Store\Products;

/**
 * Repository for storing {@link Product}s.
 */
interface ProductRepository
{
    /**
     * Create/store a new {@link Product}.
     */
    public function create(Product $product): Product;

    /**
     * Find an {@link Product} by its code.
     */
    public function findByCode(string $code): Product;
}
