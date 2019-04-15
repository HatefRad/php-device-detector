<?php
declare(strict_types=1);

namespace App;

use Detection\MobileDetect;
use App\AbstractDeviceDetector;

/**
 * DeviceDetector class.
 *
 * @package App
 */
class DeviceDetector extends AbstractDeviceDetector {

    /**
     * [detectType Detects user's device.]
     *
     * @param  MobileDetect detected object
     * @return string
     */
    public function detectType(MobileDetect $detected): string
    {
        return ($detected->isMobile() ? ($detected->isTablet() ? self::TABLET : self::PHONE) : self::DESKTOP);
    }
}
