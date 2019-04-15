<?php
declare(strict_types=1);

namespace App;

use Detection\MobileDetect;

/**
 * OSDetector class.
 *
 * @package App
 */
class OSDetector {

    const UNKNOWN_OS = 'Unknown OS';

    /**
     * [detectOS Detects the Operating System of user.]
     *
     * @param  MobileDetect detected object
     * @return string
     */
    public function detectOS(MobileDetect $detected): string
    {
        $os = self::UNKNOWN_OS;

        try {
            $agent = $_SERVER['HTTP_USER_AGENT'];
        } catch(\Exception $e) {
            return $os;
        }

        foreach($detected->getOperatingSystems() as $name => $regex) {
            $check = $detected->version($name);
            if ($check !== false) { $os = $name . ' ' . $check; }
            break;
        }

        if ($detected->isiOS()) {
            if ($detected->isTablet()) {
                $version = ' ' . $detected->version('iPad');
            } else {
                $version = ' ' . $detected->version('iPhone');
            }

            $os = 'iOS' . $version;
        } elseif ($detected->isAndroidOS()) {
            $os = 'Android';

            if ($detected->version('Android') !== false) {
                $os = $this->getAndroidVersion($detected->version('Android'));
            }
        } elseif (preg_match('/Linux/', $agent)) {
            $os = 'Linux';
        } elseif (preg_match('/Mac OS X/', $agent)) {
            $os = $this->getMacOSXVersion($agent);
        } elseif ($detected->isWindowsPhoneOS()) {
            if ($detected->version('WindowsPhone') !== false) {
                $version = ' ' . $detected->version('WindowsPhoneOS');
            }

            $os = 'Windows Phone' . $version;
        } elseif ($detected->version('Windows NT') !== false) {
            $codeName = $this->getWindowsVersion($detected->version('Windows NT'));
            $os = 'Windows' . ($codeName ?? '');
        }

        return $os;
    }

    /**
     * [getAndroidVersion]
     *
     * @param  string $version
     *
     * @return string
     */
    private function getAndroidVersion(string $version)
    {
        switch (true) {
            case $version >= 9.0: $codeName = ' (Pie)'; break;
            case $version >= 8.0: $codeName = ' (Oreo)'; break;
            case $version >= 7.0: $codeName = ' (Nougat)'; break;
            case $version >= 6.0: $codeName = ' (Marshmallow)'; break;
            case $version >= 5.0: $codeName = ' (Lollipop)'; break;
            case $version >= 4.4: $codeName = ' (KitKat)'; break;
            case $version >= 4.1: $codeName = ' (Jelly Bean)'; break;
            case $version >= 4.0: $codeName = ' (Ice Cream Sandwich)'; break;
            case $version >= 3.0: $codeName = ' (Honeycomb)'; break;
            case $version >= 2.3: $codeName = ' (Gingerbread)'; break;
            case $version >= 2.2: $codeName = ' (Froyo)'; break;
            case $version >= 2.0: $codeName = ' (Eclair)'; break;
            case $version >= 1.6: $codeName = ' (Donut)'; break;
            case $version >= 1.5: $codeName = ' (Cupcake)'; break;
            default: $codeName = ''; break;
        }

        return 'Android ' . ($version ?? '') . ($codeName ?? '');
    }

    /**
     * [getMacOSXVersion]
     *
     * @param  string $agent
     *
     * @return string
     */
    private function getMacOSXVersion(string $agent): string
    {
        $os = 'Mac OS X';

        if (preg_match('/Mac OS X 10_14/', $agent) || preg_match('/Mac OS X 10.14/', $agent)) {
            $os = 'OS X (Mojave)';
        } elseif (preg_match('/Mac OS X 10_13/', $agent) || preg_match('/Mac OS X 10.13/', $agent)) {
            $os = 'OS X (High Sierra)';
        } elseif (preg_match('/Mac OS X 10_12/', $agent) || preg_match('/Mac OS X 10.12/', $agent)) {
            $os = 'OS X (Sierra)';
        } elseif (preg_match('/Mac OS X 10_11/', $agent) || preg_match('/Mac OS X 10.11/', $agent)) {
            $os = 'OS X (El Capitan)';
        } elseif (preg_match('/Mac OS X 10_10/', $agent) || preg_match('/Mac OS X 10.10/', $agent)) {
            $os = 'OS X (Yosemite)';
        } elseif (preg_match('/Mac OS X 10_9/', $agent) || preg_match('/Mac OS X 10.9/', $agent)) {
            $os = 'OS X (Mavericks)';
        } elseif (preg_match('/Mac OS X 10_8/', $agent) || preg_match('/Mac OS X 10.8/', $agent)) {
            $os = 'OS X (Mountain Lion)';
        } elseif (preg_match('/Mac OS X 10_7/', $agent) || preg_match('/Mac OS X 10.7/', $agent)) {
            $os = 'Mac OS X (Lion)';
        } elseif (preg_match('/Mac OS X 10_6/', $agent) || preg_match('/Mac OS X 10.6/', $agent)) {
            $os = 'Mac OS X (Snow Leopard)';
        } elseif (preg_match('/Mac OS X 10_5/', $agent) || preg_match('/Mac OS X 10.5/', $agent)) {
            $os = 'Mac OS X (Leopard)';
        } elseif (preg_match('/Mac OS X 10_4/', $agent) || preg_match('/Mac OS X 10.4/', $agent)) {
            $os = 'Mac OS X (Tiger)';
        } elseif (preg_match('/Mac OS X 10_3/', $agent) || preg_match('/Mac OS X 10.3/', $agent)) {
            $os = 'Mac OS X (Panther)';
        } elseif (preg_match('/Mac OS X 10_2/', $agent) || preg_match('/Mac OS X 10.2/', $agent)) {
            $os = 'Mac OS X (Jaguar)';
        } elseif (preg_match('/Mac OS X 10_1/', $agent) || preg_match('/Mac OS X 10.1/', $agent)) {
            $os = 'Mac OS X (Puma)';
        } elseif (preg_match('/Mac OS X 10/', $agent)) {
            $os = 'Mac OS X (Cheetah)';
        }

        return $os;
    }

    /**
     * [getWindowsVersion]
     *
     * @param  string $version
     *
     * @return string
     */
    private function getWindowsVersion(string $version): string
    {
        switch ($version) {
            case 10.0: $codeName = ' 10'; break;
            case 6.3: $codeName = ' 8.1'; break;
            case 6.2: $codeName = ' 8'; break;
            case 6.1: $codeName = ' 7'; break;
            case 6.0: $codeName = ' Vista'; break;
            case 5.2: $codeName = ' Server 2003; Windows XP x64 Edition'; break;
            case 5.1: $codeName = ' XP'; break;
            case 5.01: $codeName = ' 2000, Service Pack 1 (SP1)'; break;
            case 5.0: $codeName = ' 2000'; break;
            case 4.0: $codeName = ' NT 4.0'; break;
            default: $codeName = ' NT v' . $version; break;
        }

        return $codeName;
    }
}
