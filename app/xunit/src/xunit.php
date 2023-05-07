<?php

class TestCase
{
    public function __construct(private readonly string $name)
    {
    }

    public function setUp(): void
    {

    }

    public function run(): TestResult
    {
        $result = new TestResult();
        $result->testStarted();

        $this->setUp();
        $method = $this->name;
        $this->{$method}();
        $this->tearDown();

        return $result;
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

    public function testBrokenMethod(): never
    {
        throw new Exception();
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

    public function testResult(): void
    {
        $test = new WasRun('testMethod');
        $result = $test->run();
        assert($result->summary() === '1 run, 0 failed');
    }

    public function testFailedResult(): void
    {
        $test = new WasRun('testBrokenMethod');
        $result = $test->run();
        assert($result->summary() === '1 run, 1 failed');
    }
}

class TestResult
{
    private int $runCount;

    public function __construct()
    {
        $this->runCount = 0;
    }

    public function testStarted(): void
    {
        $this->runCount = $this->runCount + 1;
    }

    public function summary(): string
    {
        return "{$this->runCount} run, 0 failed";
    }
}


(new TestCaseTest('testTemplateMethod'))->run();
(new TestCaseTest('testResult'))->run();
//(new TestCaseTest('testFailedResult'))->run();
