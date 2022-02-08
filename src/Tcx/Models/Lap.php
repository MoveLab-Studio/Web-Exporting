<?php

namespace MlsExporting\Tcx\Models;

use DateTimeInterface;
use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
class Lap implements XmlSerializable
{

    public \DateTime $startTime;
    public ?float $totalTimeSeconds = null;
    public ?float $distanceMeters = null;
    public ?float $maximumSpeed;
    public ?int $calories = null;
    public ?float $averageHeartRateBpm;
    public ?float $maximumHeartRateBpm;
    public ?Intensity $intensity = null;
    public ?float $cadence;
    public ?TriggerMethod $triggerMethod = null;
    public ?string $notes;
    public Track $track;

    public function __construct(\DateTime $startTime)
    {
        $this->startTime = $startTime;
    }

    public function toXml(): mixed
    {
        $result = [];
        $result['@StartTime'] = $this->startTime->format(DateTimeInterface::RFC3339);
        $result['TotalTimeSeconds'] = $this->totalTimeSeconds;
        $result['DistanceMeters'] = $this->distanceMeters;
        if (isset($this->maximumSpeed)) {
            $result['MaximumSpeed'] = $this->maximumSpeed;
        }
        $result['Calories'] = $this->calories;
        if (isset($this->averageHeartRateBpm)) {
            $result['AverageHeartRateBpm'] = $this->averageHeartRateBpm;
        }
        if (isset($this->maximumHeartRateBpm)) {
            $result['MaximumHeartRateBpm'] = $this->maximumHeartRateBpm;
        }
        $result['Intensity'] = $this->intensity;
        if (isset($this->cadence)) {
            $result['Cadence'] = $this->cadence;
        }
        $result['TriggerMethod'] = $this->triggerMethod;
        if (isset($this->notes)) {
            $result['Notes'] = $this->notes;
        }
        if (isset($this->track)) {
            $result['Track'] = $this->track;
        }
        return $result;
    }
}