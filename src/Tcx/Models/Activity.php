<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
class Activity implements XmlSerializable
{

    public \DateTime $id;
    public ?string $notes = null;
    public ?Sport $sport = null;

    /**
     * @var Lap[]
     */
    public array $laps;

    /**
     * @param \DateTime $id
     * @param Sport $sport
     * @param Lap[] $laps
     */
    public function __construct(\DateTime $id, Sport $sport, array $laps)
    {
        $this->id = $id;
        $this->sport = $sport;
        $this->laps = $laps;
    }

    public function toXml(): mixed
    {
        $activity = [
            '@Sport' => $this->sport,
            'Id' => $this->id->format(\DateTimeInterface::RFC3339),
            'Lap' => $this->laps,
        ];

        if (isset($this->notes)) {
            $activity['Notes'] = $this->notes;
        }

        return [
            'Activity' => $activity
        ];
    }
}