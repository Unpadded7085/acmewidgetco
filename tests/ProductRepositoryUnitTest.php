<?php

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Store\Products\InMemoryProductRepository;
use AcmeWidgetCo\Store\Products\Product;

class ProductRepositoryUnitTest extends TestCase
{
    public function testCreateSuccess(): void
    {
        $repo = new InMemoryProductRepository();
        $name = "Red Widget";
        $code = "R01";
        $priceCents = 3295;
        $product = (new Product())
            ->setName($name)
            ->setCode($code)
            ->setPriceCents($priceCents);
        $now = new DateTime();
        $product = $repo->create($product);
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($code, $product->getCode());
        $this->assertTrue($product->getCreatedAt() >= $now);
        $this->assertTrue($product->getUpdatedAt() >= $now);
    }

    public function testCreateAlreadyExists(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $repo = new InMemoryProductRepository();
        $name = "Red Widget";
        $code = "R01";
        $priceCents = 3295;
        $product = (new Product())
            ->setName($name)
            ->setCode($code)
            ->setPriceCents($priceCents);
        $product = $repo->create($product);
        // throws exception
        $repo->create($product);
    }

    public function testFindByCodeSuccess(): void
    {
        $repo = new InMemoryProductRepository();
        $name = "Red Widget";
        $code = "R01";
        $priceCents = 3295;
        $product = (new Product())
            ->setName($name)
            ->setCode($code)
            ->setPriceCents($priceCents);
        $product = $repo->create($product);
        $this->assertEquals($code, $product->getCode());
    }

    public function testFindByCodeNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $repo = new InMemoryProductRepository();
        $repo->findByCode("R01");
    }
}