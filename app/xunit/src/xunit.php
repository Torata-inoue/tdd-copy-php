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
    }
}

class WasRun extends TestCase
{
    public ?string $wasRun;
    public ?string $wasSetUp = null;

    public function testMethod(): void
    {
        $this->wasRun = '1';
    }

    public function setUp(): void
    {
        $this->wasRun = null;
        $this->wasSetUp = '1';
    }
}

class TestCaseTest extends TestCase
{
    private WasRun $test;

    public function setUp(): void
    {
        $this->test = new WasRun('testMethod');
    }

    public function testRunning(): void
    {
        $this->test->run();
        assert($this->test->wasRun);
    }

    public function testSetUp(): void
    {
        $this->test->run();
        assert($this->test->wasSetUp);
    }
}

(new TestCaseTest('testRunning'))->run();
(new TestCaseTest('testSetUp'))->run();
