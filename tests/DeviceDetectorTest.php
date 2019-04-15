<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Detection\MobileDetect;
use App\DeviceDetector;

/**
 * Test DeviceDetector.
 */
class TestDeviceDetector extends TestCase {

    protected $detect;
    protected $deviceDetector;

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mobile_Detect'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->detect = new MobileDetect;
        $this->deviceDetector = new DeviceDetector();
    }

    public function testGetDevicesAreThree()
    {
        $deviceDetector = new DeviceDetector();
        $devices = $deviceDetector->devices();

        $this->assertIsArray($devices);
        $this->assertCount(3, $devices);
    }

    public function testDetectDefaultDevice()
    {
        $detect = $this->deviceDetector->detectType(new MobileDetect());

        $this->assertEquals($detect, $this->deviceDetector::DESKTOP);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36
     */
    public function testDetectDesktop()
    {
        $type = $this->deviceDetector->detectType($this->detect);

        $this->assertEquals($type, $this->deviceDetector::DESKTOP);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Mobile Safari/537.36
     */
    public function testDetectPhone()
    {
        $type = $this->deviceDetector->detectType($this->detect);

        $this->assertEquals($type, $this->deviceDetector::PHONE);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (iPad; CPU OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1
     */
    public function testDetectTablet()
    {
        $type = $this->deviceDetector->detectType($this->detect);

        $this->assertEquals($type, $this->deviceDetector::TABLET);
    }
}
