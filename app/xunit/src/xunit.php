<?php

class TestCase
{
    public function __construct(private readonly string $name)
    {
    }

    public function run(): void
    {
        $method = $this->name;
        $this->{$method}();
    }
}

class WasRun extends TestCase
{
    public ?string $wasRun = null;

    public function testMethod(): void
    {
        $this->wasRun = '1';
    }
}

class TestCaseTest extends TestCase
{
    public function testRunning(): void
    {
        $test = new WasRun('testMethod');
        assert(is_null($test->wasRun));
        $test->run();
        assert($test->wasRun);
    }
}

(new TestCaseTest('testRunning'))->run();
