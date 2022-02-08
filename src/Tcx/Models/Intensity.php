<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

enum Intensity implements XmlSerializable
{

    case Active;
    case Resting;

    public function toXml(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Resting => 'Resting',
        };
    }
}