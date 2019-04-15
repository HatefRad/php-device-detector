<?php
declare(strict_types=1);

namespace App;

use Detection\MobileDetect;
use App\OSDetector;
use App\DeviceDetector;
use App\BrowserDetector;

/**
 * Detector class.
 *
 * @package App
 */
class Detector {

     private $deviceDetector;
     private $osDetector;
     private $browserDetector;
     private $detectedObject;

    public function __construct(
            MobileDetect $detectedObject,
            DeviceDetector $deviceDetector,
            OSDetector $osDetector,
            BrowserDetector $browserDetector
        )
    {
        $this->detectedObject = $detectedObject;
        $this->detectedObject->setDetectionType(MobileDetect::DETECTION_TYPE_EXTENDED);
        $this->deviceDetector = $deviceDetector;
        $this->osDetector = $osDetector;
        $this->browserDetector = $browserDetector;
    }

    /**
     * [detect Detect Type, OS and browser of the user.]
     *
     * @return array
     */
    public function detect(): array
    {
        $response['type'] = $this->deviceDetector->detectType($this->detectedObject);
        $response['os'] = $this->osDetector->detectOS($this->detectedObject);
        $response['browser'] = $this->browserDetector->detectBrowser($this->detectedObject);

        return $response;
    }
}
