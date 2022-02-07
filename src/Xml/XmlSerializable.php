<?php

namespace MlsExporting\Xml;

/**
 * @public
 */
interface XmlSerializable
{

    /**
     * @return mixed
     */
    public function toXml(): mixed;
}