<?php
/**
 * Created by PhpStorm.
 * User: arnostalpaert
 * Date: 19/12/2019
 * Time: 16:17
 */

namespace arnostalpaert\Transformers;

class Rijksdriehoek
{
    // Coordinates of origin (Amersfoort)
    /** @var float */
    const X0 = 155000.0;
    /** @var float */
    const Y0 = 463000.0;
    /** @var float */
    const PHI0 = 52.15517440;
    /** @var float */
    const LAM0 = 5.38720621;

    /** @var array */
    const K = [
        ['p' => 0, 'q' => 1, 'K' => 3235.65389],
        ['p' => 2, 'q' => 0, 'K' => -32.58297],
        ['p' => 0, 'q' => 2, 'K' => -0.24750],
        ['p' => 2, 'q' => 1, 'K' => -0.84978],
        ['p' => 0, 'q' => 3, 'K' => -0.06550],
        ['p' => 2, 'q' => 2, 'K' => -0.01709],
        ['p' => 1, 'q' => 0, 'K' => -0.00738],
        ['p' => 4, 'q' => 0, 'K' => 0.00530],
        ['p' => 2, 'q' => 3, 'K' => -0.00039],
        ['p' => 4, 'q' => 1, 'K' => 0.00033],
        ['p' => 1, 'q' => 1, 'K' => -0.00012]
    ];

    /** @var array */
    const L = [
        ['p' => 1, 'q' => 0, 'L' => 5260.52916],
        ['p' => 1, 'q' => 1, 'L' => 105.94684],
        ['p' => 1, 'q' => 2, 'L' => 2.45656],
        ['p' => 3, 'q' => 0, 'L' => -0.81885],
        ['p' => 1, 'q' => 3, 'L' => 0.05594],
        ['p' => 3, 'q' => 1, 'L' => -0.05607],
        ['p' => 0, 'q' => 1, 'L' => 0.01199],
        ['p' => 3, 'q' => 2, 'L' => -0.00256],
        ['p' => 1, 'q' => 4, 'L' => 0.00128]
    ];

    /**
     * Convert NL Rijksdriehoek coordinates (x,y) to WGS84 (lat,lon)
     * Formula from: https://github.com/djvanderlaan/rijksdriehoek
     *
     * @param array $position
     *
     * @return array
     */
    public static function toLatLon(array $position)
    {
        $x = $position[0];
        $y = $position[1];

        $dx = ($x - self::X0) / 1E5;
        $dy = ($y - self::Y0) / 1E5;

        $PHI = self::PHI0;
        $LAM = self::LAM0;

        foreach (self::K as $index => $val) {
            $p = self::K[$index]['p'];
            $q = self::K[$index]['q'];
            $k = self::K[$index]['K'];

            $PHI += $k * pow($dx, $p) * pow($dy, $q) / 3600;
        }

        foreach (self::L as $index => $val) {
            $p = self::L[$index]['p'];
            $q = self::L[$index]['q'];
            $l = self::L[$index]['L'];

            $LAM += $l * pow($dx, $p) * pow($dy, $q) / 3600;
        }

        return [
            'lat' => $LAM,
            'lon' => $PHI
        ];
    }
}