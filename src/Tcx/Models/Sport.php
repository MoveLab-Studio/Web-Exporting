<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
enum Sport implements XmlSerializable
{

    case Running;
    case Biking;
    case Other;

    public function toXml(): string
    {
        return match ($this) {
            self::Running => 'Running',
            self::Biking => 'Biking',
            self::Other => 'Other',
        };
    }
}