<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Detection\MobileDetect;
use App\OSDetector;

/**
 * Test OSDetector.
 */
class TestOSDetector extends TestCase {

    protected $detect;
    protected $osDetector;

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mobile_Detect'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->detect = new MobileDetect;
        $this->osDetector = new OSDetector();
    }

    public function testDetectUnknownOS()
    {
        $detect = $this->osDetector->detectOS(new MobileDetect());

        $this->assertEquals($detect, $this->osDetector::UNKNOWN_OS);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36
     */
    public function testDetectMacOSX()
    {
        $detect = $this->osDetector->detectOS(new MobileDetect());

        $this->assertStringContainsString('OS X', $detect);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (iPad; CPU OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1
     */
    public function testDetectiOS()
    {
        $detect = $this->osDetector->detectOS(new MobileDetect());

        $this->assertStringContainsString('iOS', $detect);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Linux; Android 8.0; Pixel 2 Build/OPD3.170816.012) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Mobile Safari/537.36
     */
    public function testDetectAndroid()
    {
        $detect = $this->osDetector->detectOS(new MobileDetect());

        $this->assertStringContainsString('Android', $detect);
    }
}
