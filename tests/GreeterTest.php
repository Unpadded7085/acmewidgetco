<?php

use PHPUnit\Framework\TestCase;
use ThriveCart\Test\Greeter;

class GreeterTest extends TestCase
{
    public function testGreeting(): void
    {
        $greeter = new Greeter();
        $name = "Jacob";
        $greeting = $greeter->greet($name);
        $this->assertEquals("Hello, Jacob!", $greeting);
    }
}
