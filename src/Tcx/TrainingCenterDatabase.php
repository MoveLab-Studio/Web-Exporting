<?php

namespace MlsExporting\Tcx;

use MlsExporting\Tcx\Models\Activity;
use MlsExporting\Xml\XmlSerializable;

class TrainingCenterDatabase implements XmlSerializable
{

    /** @var Activity[] */
    private array $activities;

    /**
     * @param Activity[] $activities
     */
    public function __construct(array $activities)
    {
        $this->activities = $activities;
    }

    public function toXml(): mixed
    {
        return [
            'TrainingCenterDatabase' => [
                '@xsi:schemaLocation' =>
                    'http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2 http://www.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd',
                'xmlns:ns5' => 'http://www.garmin.com/xmlschemas/ActivityGoals/v1',
                'xmlns:ns3' => 'http://www.garmin.com/xmlschemas/ActivityExtension/v2',
                'xmlns:ns2' => 'http://www.garmin.com/xmlschemas/UserProfile/v2',
                '@xmlns' => 'http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xmlns:ns4' => 'http://www.garmin.com/xmlschemas/ProfileExtension/v1',
                'Activities' => $this->activities,
            ],
        ];
    }
}