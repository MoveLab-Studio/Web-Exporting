<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

enum TriggerMethod implements XmlSerializable
{

    case Manual;
    case Distance;
    case Location;
    case Time;
    case HeartRate;

    public function toXml(): string
    {
        return match ($this) {
            self::Manual => 'Manual',
            self::Distance => 'Distance',
            self::Location => 'Location',
            self::Time => 'Time',
            self::HeartRate => 'HeartRate',
        };
    }
}