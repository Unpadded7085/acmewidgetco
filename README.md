# Acme Widget Co

This repository contains a proof of concept for a new sales system for Acme Widget Co.

## Getting Started

If you're familiar with [Nix](https://nixos.org/), you may use `nix-shell` to install the required system packages.

Otherwise, you'll need to install:

- PHP 8.2 or later (it may work with earlier versions, but this is untested)
- (Optional) [Just](https://github.com/casey/just) - a handy way to save and run project-specific commands.

Now run `just init` (or `composer install`), then `just test` (or `./vendor/bin/phpunit tests`) to run the tests.

## Example API Usage

```php
$store = Store::createDefault();
$basket = $store->createBasket();
$basket->addProduct("R01");
$basket->addProduct("G01");
$basket->addOffer("red-savings");
$totalCostCents = $basket->getTotalCents();
// $totalCostCents = 3785;
```

## Requirements

### Products

| Product      | Code | Price  |
|--------------|------|--------|
| Red Widget   | R01  | $32.95 |
| Green Widget | G01  | $24.95 |
| Blue Widget  | B01  | $7.95  |

### Delivery Costs

Delivery costs are reduced based on order cost.

| Cost  | Fee   |
|-------|-------|
| <$50  | $4.95 |
| <$90  | $2.95 |
| >=$90 | $0    |

### Special Offers

- Buy one red widget, get the second half price.

## Thoughts

I used domain-driven design for the application.
The domain is broken into 4 main areas.

1. Store/Basket
2. Delivery
3. Offers
4. Products

For offers, I decided to make this work similarly to adding products,
imagining that the user would be presented with a coupon code to add to their basket.

For storage, the repository pattern is used.
For times-sake, I've implemented an in-memory version of them using PHP arrays,
which could still be useful for testing purposes in a real application.

In the future, a database implementation would be made to persist the data.
A SQL database like MySQL or PostgreSQL would probably be best for this.

More testing is needed but is not included due to time constraints.
I have included one unit test and integration test for the store using the provided example test cases.

My personal development environment uses NixOS, so this is why I've included that complexity here.