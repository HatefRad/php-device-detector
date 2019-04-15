<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Detector;
use DI\Container;

/**
 * Test Detector.
 */
class TestDetector extends TestCase {

    protected $detect;
    protected $deviceDetector;

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container();
        $this->detector = $container->get('App\Detector');
    }

    public function testDetect()
    {
        $detected = $this->detector->detect();

        $this->assertIsArray($detected);
        $this->assertCount(3, $detected);
        $this->assertArrayHasKey('type', $detected);
        $this->assertArrayHasKey('os', $detected);
        $this->assertArrayHasKey('browser', $detected);
    }
}
