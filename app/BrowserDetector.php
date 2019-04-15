<?php
declare(strict_types=1);

namespace App;

use Detection\MobileDetect;

/**
 * BrowserDetector class.
 *
 * @package App
 */
class BrowserDetector {

    const UNKNOWN_BROWSER = 'Unknown Browser';

    /**
     * [detectBrowser Detects user's browser.]
     *
     * @param  MobileDetect detected object
     * @return string
     */
    public function detectBrowser(MobileDetect $detected): string
    {
        $browser = self::UNKNOWN_BROWSER;

        try {
            $agent = $_SERVER['HTTP_USER_AGENT'];
        } catch(\Exception $e) {
            return $browser;
        }

		if (preg_match('/Edge\/\d+/', $agent)) {
			$browser = 'Microsoft Edge ' . str_replace('12', '20', $detected->version('Edge'));
		} elseif ($detected->version('Trident') !== false && preg_match('/rv:11.0/', $agent)) {
			$browser = 'Internet Explorer 11';
		} else {
			$found = false;
			foreach($detected->getBrowsers() as $name => $regex) {
				$check = $detected->version($name);
				if ($check !== false && !$found) {
					$browser = $name . ' ' . $check;
					$found = true;
				}
			}
		}

		return $browser;
	}
}
