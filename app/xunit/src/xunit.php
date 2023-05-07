<?php

class TestCase
{
    public function __construct(private readonly string $name)
    {
    }

    public function setUp(): void
    {

    }

    public function run(TestResult $result): void
    {
        $result->testStarted();

        $this->setUp();

        try {
            $method = $this->name;
            $this->{$method}();
        } catch (Exception $e) {
            $result->testFailed();
        }
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

    public function testBrokenMethod(): never
    {
        throw new Exception();
    }
}

class TestCaseTest extends TestCase
{
    private TestResult $result;

    public function setUp(): void
    {
        $this->result = new TestResult();
    }

    public function testTemplateMethod(): void
    {
        $test = new WasRun('testMethod');
        $test->run($this->result);
        assert($test->log === 'setUp testMethod tearDown');
    }

    public function testResult(): void
    {
        $test = new WasRun('testMethod');
        $test->run($this->result);
        assert($this->result->summary() === '1 run, 0 failed');
    }

    public function testFailedResult(): void
    {
        $test = new WasRun('testBrokenMethod');
        $test->run($this->result);
        assert($this->result->summary() === '1 run, 1 failed');
    }

    public function testFailedResultFormatting(): void
    {
        $this->result->testStarted();
        $this->result->testFailed();
        assert($this->result->summary() === '1 run, 1 failed');
    }

    public function testSuite(): void
    {
        $suite = new TestSuite();
        $suite->add(new WasRun('testMethod'));
        $suite->add(new WasRun('testBrokenMethod'));
        $suite->run($this->result);
        assert($this->result->summary() === '2 run, 1 failed');
    }
}

class TestResult
{
    private int $runCount;
    private int $errorCount;

    public function __construct()
    {
        $this->runCount = 0;
        $this->errorCount = 0;
    }

    public function testStarted(): void
    {
        $this->runCount = $this->runCount + 1;
    }

    public function testFailed(): void
    {
        $this->errorCount = $this->errorCount + 1;
    }

    public function summary(): string
    {
        return "{$this->runCount} run, {$this->errorCount} failed";
    }
}

class TestSuite
{
    private array $tests = [];
    public function add(TestCase $test): void
    {
        $this->tests[] = $test;
    }

    public function run(TestResult $result): TestResult
    {
        /** @var TestCase $test */
        foreach ($this->tests as $test) {
            $test->run($result);
        }
        return $result;
    }
}

$suite = new TestSuite();
$suite->add(new TestCaseTest('testTemplateMethod'));
$suite->add(new TestCaseTest('testResult'));
$suite->add(new TestCaseTest('testFailedResult'));
$suite->add(new TestCaseTest('testFailedResultFormatting'));
$suite->add(new TestCaseTest('testSuite'));
$result = new TestResult();
$suite->run($result);

echo $result->summary() . "\n";


