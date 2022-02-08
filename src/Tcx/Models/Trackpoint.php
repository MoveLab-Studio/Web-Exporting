<?php

namespace MlsExporting\Tcx\Models;

use DateTimeInterface;
use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
class Trackpoint implements XmlSerializable
{
    public ?\DateTime $time;
    public ?float $distanceMeters;
    public ?HeartRateInBeatsPerMinute $heartRateBpm;
    public ?int $cadence;

    /**
     * @var Extension[]
     */
    public array $extensions;

    public function toXml(): mixed
    {
        $result = [];
        $result['Time'] = $this->time?->format(DateTimeInterface::RFC3339);
        if (isset($this->distanceMeters)) {
            $result['DistanceMeters'] = $this->distanceMeters;
        }
        if (isset($this->heartRateBpm)) {
            $result['HeartRateBpm'] = $this->heartRateBpm;
        }
        if (isset($this->cadence)) {
            $result['Cadence'] = $this->cadence;
        }
        if (isset($this->extensions)) {
            $result['Extensions'] = $this->extensions;
        }

        return $result;
    }
}