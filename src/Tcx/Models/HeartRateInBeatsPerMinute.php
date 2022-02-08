<?php

namespace MlsExporting\Tcx\Models;

use MlsExporting\Xml\XmlSerializable;

/**
 * @public
 */
class HeartRateInBeatsPerMinute implements XmlSerializable
{

    public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toXml(): mixed
    {
        return ['Value' => $this->value];
    }
}