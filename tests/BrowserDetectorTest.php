<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Detection\MobileDetect;
use App\BrowserDetector;

/**
 * Test BrowserDetector.
 */
class TestBrowserDetector extends TestCase {

    protected $detect;
    protected $browserDetector;

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mobile_Detect'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->detect = new MobileDetect;
        $this->browserDetector = new BrowserDetector();
    }

    public function testDetectUnknownBrowser()
    {
        $detect = $this->browserDetector->detectBrowser(new MobileDetect());

        $this->assertEquals($detect, $this->browserDetector::UNKNOWN_BROWSER);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36
     */
    public function testDetectChrome()
    {
        $detect = $this->browserDetector->detectBrowser(new MobileDetect());

        $this->assertStringContainsString('Chrome', $detect);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion
     */
    public function testDetectFirefox()
    {
        $detect = $this->browserDetector->detectBrowser(new MobileDetect());

        $this->assertStringContainsString('Firefox', $detect);
    }

    /**
     * Set the user agent.
     *
     * @server HTTP_USER_AGENT=Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10136
     */
    public function testDetectMicrosoftEdge()
    {
        $detect = $this->browserDetector->detectBrowser(new MobileDetect());

        $this->assertStringContainsString('Microsoft Edge', $detect);
    }
}
