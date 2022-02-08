<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
class Track implements XmlSerializable
{

    /**
     * @var Trackpoint[]
     */
    public array $trackpoints;

    /**
     * @param Trackpoint[] $trackpoints
     */
    public function __construct(array $trackpoints)
    {
        $this->trackpoints = $trackpoints;
    }

    public function toXml(): mixed
    {
        return ['Trackpoint' => $this->trackpoints];
    }
}