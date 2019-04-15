<?php
declare(strict_types=1);

namespace App;

/**
 * AbstractDeviceDetector class.
 *
 * @package App
 */
class AbstractDeviceDetector {

    const PHONE = 'Phone';
    const TABLET = 'Tablet';
    const DESKTOP = 'Desktop';

    public function devices(): array
    {
        return [
                    ['type' => self::PHONE, 'image' => 'phone.svg'],
                    ['type' => self::TABLET, 'image' => 'tablet.svg'],
                    ['type' => self::DESKTOP, 'image' => 'desktop.svg']
                ];
    }
}
