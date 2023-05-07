<?php

class TestCase
{
    public function __construct(private readonly string $name)
    {
    }

    public function setUp(): void
    {

    }

    public function run(): void
    {
        $this->setUp();
        $method = $this->name;
        $this->{$method}();
        $this->tearDown();
    }

    public function tearDown(): void
    {

    }
}

class WasRun extends TestCase
{
    public string $log;

    public function testMethod(): void
    {
        $this->log = $this->log . ' testMethod';
    }

    public function setUp(): void
    {
        $this->log = 'setUp';
    }

    public function tearDown(): void
    {
        $this->log = $this->log . ' tearDown';
    }
}

class TestCaseTest extends TestCase
{
    public function testTemplateMethod(): void
    {
        $test = new WasRun('testMethod');
        $test->run();
        assert($test->log === 'setUp testMethod tearDown');
    }
}

(new TestCaseTest('testTemplateMethod'))->run();
