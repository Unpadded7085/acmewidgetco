# Show help
help:
  just --list --unsorted

# Run tests
test:
  ./vendor/bin/phpunit tests

# Format .nix files
format-nix:
  find ./ -name '*.nix' -exec nixfmt {} \; -exec nixfmt {} \;

# Format .php files
format-php:
    ./vendor/bin/php-cs-fixer fix

# Format source files
format: format-nix format-php
