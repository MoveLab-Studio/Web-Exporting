<?php

namespace MlsExporting\Tcx\Models;

/**
 * @public
 * @link https://www8.garmin.com/xmlschemas/ActivityExtensionv2.xsd
 */
class ActivityExtension implements Extension
{
    public ?float $speed;
    public ?float $watts;

    public function toXml(): mixed
    {
        $tpx = [
            '@xmlns' => 'http://www.garmin.com/xmlschemas/ActivityExtension/v2',
        ];
        if (isset($this->speed)) {
            $tpx['Speed'] = $this->speed;
        }
        if (isset($this->watts)) {
            $tpx['Watts'] = $this->watts;
        }
        return ['TPX' => $tpx];
    }
}